<?php

namespace App\Http\Controllers\user;

use App\Models\Buku;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardUserController extends Controller
{
    public function index(){
        return view('user.index');

    } 

    public function daftarbuku(){
       $bukus = Buku::with('kategori')->latest()->get();

        return view('user.daftarbuku', compact('bukus'));
    }

    public function detail($id){
    $buku = Buku::with(['kategori', 'penerbit'])->findOrFail($id);


    return view('user.showbuku', compact('buku'));
}

}
