<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use App\Models\PeminjamanBuku;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $dari = $request->dari;
        $sampai = $request->sampai;

      $peminjaman = Peminjaman::withCount('peminjamanBukus')
    ->when($dari && $sampai, function ($query) use ($dari, $sampai) {
        $query->whereBetween('tgl_peminjaman', [$dari, $sampai]);
    })
    ->paginate(10)
    ->withQueryString();

        return view('laporan-admin.index', compact('peminjaman', 'dari', 'sampai'));
    }
    public function detail($id){
        $data = PeminjamanBuku::with('buku','peminjaman')->where('peminjaman_id',$id)->paginate(10);
        return view('laporan-admin.detail',compact('data'));
    }
}
