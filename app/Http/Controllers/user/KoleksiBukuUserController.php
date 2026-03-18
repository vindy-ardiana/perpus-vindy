<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\TransaksiPeminjaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KoleksiBukuUserController extends Controller
{
    public function index(){
        $buku = TransaksiPeminjaman::with(['buku.kategoris', 'buku.penerbit'])
                ->where('status', 'Setuju')
                ->where('status_pengembalian', 'Dipinjam')
                ->where('user_id', Auth::user()->id)
                ->latest()
                ->get();
        return view('user.koleksi', compact('buku'));
    }

    public function riwayat(){
        $riwayat = TransaksiPeminjaman::with(['buku.kategoris', 'buku.penerbit', 'ulasan'])
                ->where('user_id', Auth::user()->id)
                ->latest()
                ->get();
        return view('user.riwayat', compact('riwayat'));
    }

    /** Cetak riwayat peminjaman user ke PDF */
    public function riwayatPdf()
    {
        $user = Auth::user();
        $riwayat = TransaksiPeminjaman::with(['buku.kategoris', 'buku.penerbit'])
            ->where('user_id', $user->id)
            ->latest('tgl_peminjaman')
            ->get();

        $pdf = Pdf::loadView('user.riwayat-pdf', compact('user', 'riwayat'));
        $pdf->setPaper('a4', 'portrait');
        return $pdf->download('riwayat-peminjaman-' . $user->id . '-' . date('Y-m-d') . '.pdf');
    }
}
