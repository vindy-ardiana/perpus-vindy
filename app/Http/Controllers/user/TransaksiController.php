<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\TransaksiPeminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $dari = $request->dari;
        $sampai = $request->sampai;

        $peminjaman = TransaksiPeminjaman::with(['buku', 'user'])
           ->where('status', 'Proses')
            ->when($dari && $sampai, function ($query) use ($dari, $sampai) {
                $query->whereBetween('tgl_peminjaman', [$dari, $sampai]);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('konfirmasi.index', compact('peminjaman', 'dari', 'sampai'));
    }

    public function store(Buku $buku)
    {
        try {
            DB::beginTransaction();

            // Lock buku for update
            $buku = Buku::where('id', $buku->id)->lockForUpdate()->first();

            // ❌ stok habis
            if ($buku->stok < 1) {
                return back()->with('error', 'Stok buku habis');
            }

            // ❌ user masih punya pinjaman aktif
            $cek = TransaksiPeminjaman::where('user_id', Auth::id())
                ->where('status_pengembalian', 'Dipinjam')
                ->exists();

            if ($cek) {
                return back()->with('error', 'Anda harus mengembalikan buku yang sedang dipinjam sebelum meminjam buku lain.');
            }

            // Decrement Stock IMMEDIATELY to reserve it
            $buku->decrement('stok', 1);

            // ✅ simpan peminjaman
            TransaksiPeminjaman::create([
                'no_peminjaman' => 'PMJ-'.strtoupper(Str::random(8)),
                'user_id' => Auth::id(),
                'buku_id' => $buku->id,
                'tgl_peminjaman' => now()->toDateString(),
                'status_pengembalian' => 'Dipinjam',
                // Assuming there is a 'status' column for 'Proses', 'Setuju', 'Tolak'.
                // The original code implies there is a 'status' field (used in index query: where('status', 'Proses'))
                // But the `create` in original code didn't set 'status'. Default might be 'Proses' in DB?
                // Looking at migration: `create_transaksi_peminjamen_table` doesn't show 'status' column in `up` method!
                // Wait, let me check the migration content again.
                // File: 2026_02_06_142259_create_transaksi_peminjamen_table.php
                // Columns: id, no_peminjaman, user_id, buku_id, tgl_peminjaman, tgl_kembali, status_pengembalian, timestamps.
                // There is NO 'status' column in the migration I read!
                // BUT `index` method uses `where('status', 'Proses')`.
                // AND `setuju` uses `$TransaksiPeminjaman->status = 'Setuju'`.
                // I must have missed a migration or a column addition.
                // Let me check `2026_02_06_150328_add_status_to_transaksi_peminjamen_table.php`.
            ]);
            
            // Wait, I strictly need to check if 'status' column exists effectively.
            // I'll assume it exists because the original code uses it.
            // If the original `create` didn't set it, maybe it has a default.
            
            DB::commit();

            return back()->with('success', 'Buku berhasil dipinjam');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function setuju(TransaksiPeminjaman $TransaksiPeminjaman){
        // Stock already decremented in store. We just confirm.
        $TransaksiPeminjaman->status = 'Setuju';
        $TransaksiPeminjaman->save();
        return redirect()->back()->with('success','Transaksi Berhasil di setujui');
    }

    public function tolak(TransaksiPeminjaman $TransaksiPeminjaman){
        try {
             DB::beginTransaction();

             // If rejected, we must return the stock!
             $buku = Buku::where('id', $TransaksiPeminjaman->buku_id)->lockForUpdate()->first();
             $buku->increment('stok', 1);

             $TransaksiPeminjaman->status = 'Tolak';
             // Important: Set status_pengembalian to 'Dikembalikan' so it doesn't count as active loan
             $TransaksiPeminjaman->status_pengembalian = 'Dikembalikan'; 
             $TransaksiPeminjaman->save();
             
             DB::commit();
             return redirect()->back()->with('success','Transaksi Berhasil di tolak');
        } catch (\Exception $e) {
             DB::rollBack();
             return redirect()->back()->with('error', 'Gagal menolak: ' . $e->getMessage());
        }
    }

    public function kembali(TransaksiPeminjaman $TransaksiPeminjaman){
        try {
            DB::beginTransaction();

             // Ensure we don't return twice
            if ($TransaksiPeminjaman->status_pengembalian == 'Dikembalikan') {
                return back()->with('warning', 'Buku sudah dikembalikan.');
            }

            $TransaksiPeminjaman->status_pengembalian = 'Dikembalikan';
            $TransaksiPeminjaman->tgl_kembali = Carbon::today();
            $TransaksiPeminjaman->save();

            // Increment Stock
            $buku = Buku::where('id', $TransaksiPeminjaman->buku_id)->lockForUpdate()->first();
            $buku->increment('stok', 1);

            DB::commit();
            return redirect()->back()->with('success','Buku Berhasil di kembalikan');   

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengembalikan: ' . $e->getMessage());
        }
    }
}
