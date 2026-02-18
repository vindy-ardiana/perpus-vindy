<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\TransaksiPeminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KoleksiBukuUserController extends Controller
{
    public function index(){
        $buku = TransaksiPeminjaman::with('buku')
                ->where('status_pengembalian','Dipinjam')
                ->where('user_id', Auth::user()->id)->get();
        return view('user.koleksi',compact('buku'));
    }
    public function riwayat(){
         $riwayat = TransaksiPeminjaman::with('buku')
                ->where('status_pengembalian','Dikembalikan')
                ->where('user_id', Auth::user()->id)->get();
        return view('user.riwayat',compact('riwayat'));
    }
}
