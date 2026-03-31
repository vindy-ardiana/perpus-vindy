<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Koleksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KoleksiController extends Controller
{
    /**
     * Tampilkan koleksi pribadi user
     */
    public function index()
    {
        $koleksi = Koleksi::with('buku.kategoris', 'buku.penerbit')
            ->where('user_id', Auth::user()->id)
            ->latest()
            ->get();
        return view('user.koleksi-pribadi', compact('koleksi'));
    }

    /**
     * Simpan buku ke koleksi pribadi user (bookmark).
     */
    public function simpan(Request $request, Buku $buku)
    {
        $user_id = Auth::user()->id;

        // Cek apakah buku sudah ada di koleksi
        $exists = Koleksi::where('user_id', $user_id)
            ->where('buku_id', $buku->id)
            ->exists();

        if ($exists) {
            return redirect()->route('user.koleksi-pribadi')->with('info', 'Buku "'.$buku->judul.'" sudah ada di koleksi pribadi.');
        }

        // Simpan ke koleksi
        Koleksi::create([
            'user_id' => $user_id,
            'buku_id' => $buku->id,
        ]);

        return redirect()->route('user.koleksi-pribadi')->with('success', 'Buku "'.$buku->judul.'" berhasil disimpan ke koleksi pribadi.');
    }

    /**
     * Hapus buku dari koleksi pribadi
     */
    public function hapus(Koleksi $koleksi)
    {
        $buku_judul = $koleksi->buku->judul;

        // Cek apakah koleksi milik user yang login
        if ($koleksi->user_id !== Auth::user()->id) {
            return back()->with('error', 'Anda tidak memiliki akses untuk menghapus koleksi ini.');
        }

        $koleksi->delete();

        return back()->with('success', 'Buku "'.$buku_judul.'" berhasil dihapus dari koleksi pribadi.');
    }
}
