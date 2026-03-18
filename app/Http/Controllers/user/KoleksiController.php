<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KoleksiController extends Controller
{
    /**
     * Simpan buku ke koleksi user (bookmark).
     * Untuk sementara hanya redirect dengan pesan; bisa dikembangkan dengan tabel koleksi nanti.
     */
    public function simpan(Request $request, Buku $buku)
    {
        // Placeholder: belum ada tabel koleksi. Redirect dengan pesan sukses.
        return back()->with('success', 'Buku "'.$buku->judul.'" berhasil disimpan ke koleksi.');
    }
}
