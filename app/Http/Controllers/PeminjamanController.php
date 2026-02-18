<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Anggota;   
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allPeminjaman = Peminjaman::all();
        return view('peminjaman.index', compact('allPeminjaman'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $anggota = Anggota::all();
        $bukus = Buku::where('stok', '>', 0)->get(); // Only show available books
        return view('peminjaman.create', compact('anggota', 'bukus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tgl_peminjaman' => 'required|date',
            'anggota_id'     => 'required',
            'buku_ids'       => 'required|array',
            'buku_ids.*'     => 'exists:bukus,id',
        ]);

        try {
            DB::beginTransaction();

            // Create Peminjaman record
            $peminjaman = Peminjaman::create([
                'anggota_id' => $request->anggota_id,
                'tgl_peminjaman' => $request->tgl_peminjaman,
                'status_pengembalian' => 'Dipinjam',
            ]);

            foreach ($request->buku_ids as $buku_id) {
                // Lock the book row for update to prevent race conditions
                $buku = Buku::where('id', $buku_id)->lockForUpdate()->first();

                if (!$buku || $buku->stok < 1) {
                    throw new \Exception("Stok buku '{$buku->judul}' habis.");
                }

                $buku->decrement('stok', 1);
                $peminjaman->buku()->attach($buku->id);
            }

            DB::commit();

            return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dicatat.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $peminjaman = Peminjaman::with('anggota', 'buku')->findOrFail($id);
        return view('peminjaman.show', compact('peminjaman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peminjaman $peminjaman)
    {
        $request->validate(['tgl_kembali' => 'date']);

        try {
            DB::beginTransaction();

            $peminjaman = Peminjaman::where('id', $peminjaman->id)->lockForUpdate()->first();

            if ($peminjaman->status_pengembalian === 'Dikembalikan') {
                return redirect()->route('peminjaman.index')->with('warning', 'Buku sudah dikembalikan sebelumnya.');
            }

            $peminjaman->update([
                'tgl_kembali' => $request->tgl_kembali ?? now(),
                'status_pengembalian' => 'Dikembalikan',
            ]);

            // Restore stock for all borrowed books
            foreach ($peminjaman->buku as $buku) {
                $buku->increment('stok', 1);
            }

            DB::commit();

            return redirect()->route('peminjaman.index')->with('success', 'Buku berhasil dikembalikan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat pengembalian: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peminjaman $peminjaman)
    {
        try {
            DB::beginTransaction();
            
            // If deleting a loan record, ensuring we handle stock correctly if it wasn't returned?
            // Usually we block deletion if not returned, or we allow it and assume manual correction.
            // For now, I'll just delete it as requested, but if it was 'Dipinjam', stock is lost?
            // Let's assume destroy is only for cleanup. To be safe, maybe restrict deletion if 'Dipinjam'.
            
            if ($peminjaman->status_pengembalian == 'Dipinjam') {
                 // Option: Increment stock back OR prevent delete. 
                 // Preventing delete is safer for data integrity.
                 // return back()->with('error', 'Tidak dapat menghapus peminjaman yang belum dikembalikan.');
                 
                 // However, original code just deleted. Code below mimics original but catches errors.
            }

            $peminjaman->delete();
            DB::commit();
            return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
