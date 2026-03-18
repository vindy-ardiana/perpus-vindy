<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\TransaksiPeminjaman;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    /** User menulis ulasan dan rating */
    public function store(Request $request, TransaksiPeminjaman $transaksi)
    {
        $request->validate([
            'isi_ulasan' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        if ($transaksi->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized.');
        }
        if ($transaksi->status !== 'Setuju') {
            return back()->with('error', 'Ulasan hanya dapat ditulis untuk peminjaman yang sudah disetujui.');
        }
        if ($transaksi->ulasan) {
            return back()->with('error', 'Anda sudah mengirim ulasan untuk transaksi ini.');
        }

        Ulasan::create([
            'transaksi_peminjaman_id' => $transaksi->id,
            'user_id' => Auth::id(),
            'isi_ulasan' => $request->isi_ulasan,
            'rating' => $request->rating,
        ]);
        return back()->with('success', 'Ulasan berhasil dikirim.');
    }
}
