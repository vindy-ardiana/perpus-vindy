<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AuthManualController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\user\DashboardUserController;
use App\Http\Controllers\user\KoleksiBukuUserController;
use App\Http\Controllers\user\TransaksiController;
use Illuminate\Support\Facades\Route;




Route::get('/', function () {
    return view('index'); // halaman yg ada "Selamat Datang"
    })->name('index');


Route::get('/dashboard', function () {
    return view('test'); // halaman yg ada "Selamat Datang"
    })->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::resource('kategori',KategoriController::class);
    Route::resource('penerbit',PenerbitController::class);
    Route::resource('buku',BukuController::class);
    Route::resource('anggota',AnggotaController::class)->parameters(['anggota' => 'anggota']);
    Route::resource('peminjaman', PeminjamanController::class);
    Route::get('/laporan/{id}/detail',[LaporanController::class,'detail'])->name('laporan.detail');
    Route::get('/laporan',[LaporanController::class,'index'])->name('laporan.admin');

    Route::get('/dashboard', [BukuController::class, 'count'])->name('dashboard'); //buat ngitung total yg ada di dashboard
    Route::get('/konfirmasi',[TransaksiController::class,'index'])->name('konfirmasi.index');
    Route::get('/konfirmasi/{TransaksiPeminjaman}',[TransaksiController::class,'setuju'])->name('setuju');
    Route::get('/konfirmasi/tolak/{TransaksiPeminjaman}',[TransaksiController::class,'tolak'])->name('tolak');


});


//USERRRRRRRRRRRRRRRR
Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [DashboardUserController::class, 'index'])->name('user.dashboard');
    Route::get('/user/daftarbuku', [DashboardUserController::class, 'daftarbuku'])->name('user.daftarbuku');
    Route::get('/user/buku/{id}', [DashboardUserController::class, 'detail'])->name('user.buku.detail');
    Route::post('/pinjam-buku/{buku}', [TransaksiController::class, 'store'])->name('pinjam.buku');
    Route::get('/user/kembalikan/{TransaksiPeminjaman}',[TransaksiController::class,'kembali'])->name('user.kembalikan');
    Route::get('/user/koleksi',[KoleksiBukuUserController::class,'index'])->name('user.koleksi');
    Route::get('/user/riwayat',[KoleksiBukuUserController::class,'riwayat'])->name('user.riwayat');
});

//Route untuk login dan logout 
Route::get('/login', [AuthManualController::class, 'index'])->name('login');
Route::get('/registrasi', [AuthManualController::class, 'registrasi'])->name('registrasi');
Route::post('/registrasi', [AuthManualController::class, 'registrasiProses'])->name('registrasiProses');
Route::post('/login', [AuthManualController::class, 'loginProses'])->name('loginProses');
Route::post('/logout',[AuthManualController::class, 'logout'])->name('logout');

//Route untuk test
Route::get('/tes', function () {
    return view('test');
});
