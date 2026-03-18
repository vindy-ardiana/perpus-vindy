<?php

namespace App\Http\Controllers\user;

use App\Models\Buku;
use App\Models\TransaksiPeminjaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardUserController extends Controller
{

public function index()
{
    $userId = Auth::id();

    $total = TransaksiPeminjaman::where('user_id', $userId)->count();

    $dipinjam = TransaksiPeminjaman::where('user_id', $userId)
                ->where('status_pengembalian','Dipinjam')
                ->count();

    $kembali = TransaksiPeminjaman::where('user_id', $userId)
                ->where('status_pengembalian','Dikembalikan')
                ->count();

    $jumlahBelumUlasan = 0; // tambahkan ini dulu supaya tidak error

    return view('user.index', compact(
        'total',
        'dipinjam',
        'kembali',
        'jumlahBelumUlasan'
    ));
}

    // public function index(){
    //     $jumlahBelumUlasan = TransaksiPeminjaman::where('user_id', Auth::id())
    //         ->where('status', 'Setuju')
    //         ->whereDoesntHave('ulasan')
    //         ->count();
    //     return view('user.index', compact('jumlahBelumUlasan'));
    // }

    public function daftarbuku(){
        $bukus = Buku::with('kategoris')->withAvg('ulasans', 'rating')->latest()->get();
        return view('user.daftarbuku', compact('bukus'));
    }

    public function detail($id){
        $buku = Buku::with(['kategoris', 'penerbit'])->findOrFail($id);
        $user = Auth::user();
        $canBorrow = true;
        $pinjamBlockMessage = null;

        if ($user->isBanned()) {
            $canBorrow = false;
            $pinjamBlockMessage = 'Anda sedang dalam hukuman, tidak bisa pinjam buku. Masa banned sampai ' . $user->banned_until->format('d/m/Y') . '.';
        } else {
            $pinjamanAktif = TransaksiPeminjaman::where('user_id', $user->id)
                ->where('status', 'Setuju')
                ->where('status_pengembalian', 'Dipinjam')
                ->get();
            foreach ($pinjamanAktif as $p) {
                $lama = (int) ($p->lama_pinjam_hari ?? TransaksiPeminjaman::MASA_PINJAM_HARI);
                $batas = $p->tgl_peminjaman->copy()->addDays(max(1, min(7, $lama)));
                if (now()->startOfDay()->gt($batas)) {
                    $canBorrow = false;
                    $pinjamBlockMessage = 'Anda terlambat mengembalikan buku. Silakan kembalikan buku yang dipinjam terlebih dahulu.';
                    break;
                }
            }
            if ($canBorrow && $pinjamanAktif->isNotEmpty()) {
                $canBorrow = false;
                $pinjamBlockMessage = 'Anda harus mengembalikan buku yang sedang dipinjam sebelum meminjam buku lain.';
            }
            // User tidak bisa pinjam buku yang sama jika masih ada pinjaman aktif (buku belum dikembalikan)
            if ($canBorrow) {
                $pinjamBukuSama = TransaksiPeminjaman::where('user_id', $user->id)
                    ->where('buku_id', $buku->id)
                    ->where('status', 'Setuju')
                    ->whereIn('status_pengembalian', ['Dipinjam', 'MenungguPengembalian'])
                    ->exists();
                if ($pinjamBukuSama) {
                    $canBorrow = false;
                    $pinjamBlockMessage = 'Anda masih memiliki pinjaman buku ini yang belum dikembalikan.';
                }
            }
        }

        $transaksiBukti = null;
        if (Session::has('pinjam_success_id')) {
            $transaksiBukti = TransaksiPeminjaman::with(['buku.penerbit'])->find(Session::get('pinjam_success_id'));
            Session::forget('pinjam_success_id');
        }

        return view('user.showbuku', compact('buku', 'canBorrow', 'pinjamBlockMessage', 'transaksiBukti'));
    }

    /** Download PDF bukti peminjaman (setelah user ajukan pinjam) */
    public function buktiPeminjamanPdf(TransaksiPeminjaman $transaksi)
    {
        if ($transaksi->user_id !== Auth::id()) {
            abort(403);
        }
        $transaksi->load(['buku.penerbit', 'user']);
        $pdf = Pdf::loadView('user.bukti-peminjaman-pdf', compact('transaksi'));
        $pdf->setPaper('a4', 'portrait');
        return $pdf->download('bukti-peminjaman-' . $transaksi->no_peminjaman . '.pdf');
    }
}
