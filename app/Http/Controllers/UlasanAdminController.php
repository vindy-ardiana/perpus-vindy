<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use Illuminate\Http\Request;

class UlasanAdminController extends Controller
{
    public function index()
    {
        $ulasan = Ulasan::with(['transaksiPeminjaman.buku', 'user'])
            ->latest()
            ->paginate(15);
        return view('ulasan.index', compact('ulasan'));
    }

    public function destroy(Ulasan $ulasan)
    {
        $ulasan->delete();
        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
