<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\TransaksiPeminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    /** Halaman pilih: Konfirmasi Peminjaman atau Konfirmasi Pengembalian */
    public function index()
    {
        // return view('konfirmasi.index');
    }

    /** Daftar pengajuan peminjaman (status Proses) - approve setuju/tolak */
    public function indexPeminjaman(Request $request)
    {
        $dari = $request->dari;
        $sampai = $request->sampai;
        $query = TransaksiPeminjaman::with(['buku', 'user'])
            ->where('status', 'Proses');

        $peminjaman = $query
            ->when($dari && $sampai, function ($q) use ($dari, $sampai) {
                $q->whereBetween('tgl_peminjaman', [$dari, $sampai]);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('konfirmasi.peminjaman', compact('peminjaman', 'dari', 'sampai'));
    }

    /** Daftar pengajuan pengembalian (MenungguPengembalian) - approve setujui/tolak */
    public function indexPengembalian(Request $request)
    {
        $dari = $request->dari;
        $sampai = $request->sampai;
        $query = TransaksiPeminjaman::with(['buku', 'user'])
            ->where('status', 'Setuju')
            ->where('status_pengembalian', 'MenungguPengembalian');

        $pengembalian = $query
            ->when($dari && $sampai, function ($q) use ($dari, $sampai) {
                $q->whereBetween('tgl_peminjaman', [$dari, $sampai]);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('konfirmasi.pengembalian', compact('pengembalian', 'dari', 'sampai'));
    }

    public function store(Request $request, Buku $buku)
    {
        $request->validate([
            'tgl_peminjaman' => 'required|date',
            'tgl_pengembalian_rencana' => 'required|date|after_or_equal:tgl_peminjaman',
        ]);

        $tglPinjam = Carbon::parse($request->tgl_peminjaman);
        $tglKembali = Carbon::parse($request->tgl_pengembalian_rencana);
        if ($tglPinjam->diffInDays($tglKembali) > 7) {
            return back()->with('error', 'Maksimal lama pinjam 7 hari.');
        }

        try {
            $user = Auth::user();

            if ($user->isBanned()) {
                return back()->with('error', 'Anda sedang dalam hukuman. Masa banned sampai ' . $user->banned_until->format('d/m/Y') . '.');
            }

            $pinjamanAktif = TransaksiPeminjaman::where('user_id', Auth::id())
                ->where('status', 'Setuju')
                ->whereIn('status_pengembalian', ['Dipinjam', 'MenungguPengembalian'])
                ->get();
            foreach ($pinjamanAktif as $p) {
                $batas = $p->batas_kembali;
                if (now()->startOfDay()->gt($batas)) {
                    return back()->with('error', 'Anda terlambat mengembalikan buku. Silakan kembalikan buku yang dipinjam terlebih dahulu.');
                }
            }
            if ($pinjamanAktif->isNotEmpty()) {
                return back()->with('error', 'Anda harus mengembalikan buku yang sedang dipinjam sebelum meminjam buku lain.');
            }

            $pinjamBukuSama = TransaksiPeminjaman::where('user_id', Auth::id())
                ->where('buku_id', $buku->id)
                ->where('status', 'Setuju')
                ->whereIn('status_pengembalian', ['Dipinjam', 'MenungguPengembalian'])
                ->exists();
            if ($pinjamBukuSama) {
                return back()->with('error', 'Anda masih memiliki pinjaman buku ini yang belum dikembalikan.');
            }

            DB::beginTransaction();
            $buku = Buku::where('id', $buku->id)->lockForUpdate()->first();
            if ($buku->stok < 1) {
                return back()->with('error', 'Stok buku habis');
            }

            $transaksi = TransaksiPeminjaman::create([
                'no_peminjaman' => 'PMJ-'.strtoupper(Str::random(8)),
                'user_id' => Auth::id(),
                'buku_id' => $buku->id,
                'tgl_peminjaman' => $request->tgl_peminjaman,
                'tgl_pengembalian_rencana' => $request->tgl_pengembalian_rencana,
                'status' => 'Proses',
                'status_pengembalian' => 'Dipinjam',
            ]);

            DB::commit();

            return redirect()->route('user.buku.detail', $buku->id)
                ->with('success', 'Pengajuan peminjaman berhasil dikirim. Menunggu konfirmasi admin.')
                ->with('pinjam_success_id', $transaksi->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function setuju(TransaksiPeminjaman $TransaksiPeminjaman){
        try {
            DB::beginTransaction();
            $buku = Buku::where('id', $TransaksiPeminjaman->buku_id)->lockForUpdate()->first();
            if ($buku->stok < 1) {
                return redirect()->back()->with('error', 'Stok buku habis.');
            }
            $buku->decrement('stok', 1);
            $TransaksiPeminjaman->status = 'Setuju';
            $TransaksiPeminjaman->save();
            DB::commit();
            return redirect()->back()->with('success','Transaksi berhasil disetujui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyetujui: ' . $e->getMessage());
        }
    }

    public function tolak(TransaksiPeminjaman $TransaksiPeminjaman){
        try {
            DB::beginTransaction();
            // Stok tidak pernah dikurangi saat pengajuan, jadi tidak perlu increment
            $TransaksiPeminjaman->status = 'Tolak';
            $TransaksiPeminjaman->status_pengembalian = 'Dikembalikan';
            $TransaksiPeminjaman->save();
            DB::commit();
            return redirect()->back()->with('success','Transaksi berhasil ditolak.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menolak: ' . $e->getMessage());
        }
    }

    public function kembali(TransaksiPeminjaman $TransaksiPeminjaman){
        try {
            DB::beginTransaction();

            if ($TransaksiPeminjaman->status_pengembalian == 'Dikembalikan') {
                return back()->with('warning', 'Buku sudah dikembalikan.');
            }

            $tglKembali = Carbon::today()->startOfDay();
            $TransaksiPeminjaman->status_pengembalian = 'Dikembalikan';
            $TransaksiPeminjaman->tgl_kembali = $tglKembali;
            $TransaksiPeminjaman->save();

            $buku = Buku::where('id', $TransaksiPeminjaman->buku_id)->lockForUpdate()->first();
            $buku->increment('stok', 1);

            // Hukuman: jika telat (kembali lewat dari batas), banned 7 hari
            $lamaHari = (int) ($TransaksiPeminjaman->lama_pinjam_hari ?? TransaksiPeminjaman::MASA_PINJAM_HARI);
            $batasKembali = Carbon::parse($TransaksiPeminjaman->tgl_peminjaman)->startOfDay()->addDays($lamaHari);
            $terlambat = $tglKembali->gt($batasKembali);

            if ($terlambat) {
                $bannedSampai = $tglKembali->copy()->addDays(7)->format('Y-m-d');
                DB::table('users')->where('id', $TransaksiPeminjaman->user_id)->update(['banned_until' => $bannedSampai]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Buku berhasil dikembalikan.' . ($terlambat ? ' Peminjam terlambat dan mendapat hukuman banned 7 hari.' : ''));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengembalikan: ' . $e->getMessage());
        }
    }

    public function show(TransaksiPeminjaman $TransaksiPeminjaman)
    {
        $TransaksiPeminjaman->load(['buku.kategoris', 'buku.penerbit', 'user']);
        return view('konfirmasi.show', compact('TransaksiPeminjaman'));
    }

    /** User mengajukan pengembalian buku */
    public function ajukanPengembalian(TransaksiPeminjaman $transaksi)
    {
        if ($transaksi->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized.');
        }
        if ($transaksi->status !== 'Setuju' || $transaksi->status_pengembalian !== 'Dipinjam') {
            return back()->with('error', 'Transaksi tidak valid untuk diajukan pengembalian.');
        }
        $transaksi->status_pengembalian = 'MenungguPengembalian';
        $transaksi->save();
        return back()->with('success', 'Pengajuan pengembalian berhasil dikirim. Menunggu konfirmasi admin.');
    }

    /** Admin setujui pengembalian (gantikan fungsi kembali lama) */
    public function setujuiPengembalian(TransaksiPeminjaman $transaksi)
    {
        if (!in_array($transaksi->status_pengembalian, ['Dipinjam', 'MenungguPengembalian'])) {
            return back()->with('warning', 'Buku sudah dikembalikan.');
        }
        try {
            DB::beginTransaction();
            $tglKembali = Carbon::today()->startOfDay();
            $transaksi->status_pengembalian = 'Dikembalikan';
            $transaksi->tgl_kembali = $tglKembali;
            $transaksi->save();

            $buku = Buku::where('id', $transaksi->buku_id)->lockForUpdate()->first();
            $buku->increment('stok', 1);

            $batasKembali = $transaksi->batas_kembali;
            $terlambat = $tglKembali->gt($batasKembali);
            if ($terlambat) {
                DB::table('users')->where('id', $transaksi->user_id)->update(['banned_until' => $tglKembali->copy()->addDays(7)->format('Y-m-d')]);
            }
            DB::commit();
            return redirect()->back()->with('success', 'Pengembalian disetujui.' . ($terlambat ? ' Peminjam terlambat, banned 7 hari.' : ''));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    /** Admin tolak pengembalian */
    public function tolakPengembalian(TransaksiPeminjaman $transaksi)
    {
        if ($transaksi->status_pengembalian !== 'MenungguPengembalian') {
            return back()->with('error', 'Hanya pengajuan yang menunggu yang bisa ditolak.');
        }
        $transaksi->status_pengembalian = 'Dipinjam';
        $transaksi->save();
        return back()->with('success', 'Pengajuan pengembalian ditolak. User dapat mengajukan kembali.');
    }
}
