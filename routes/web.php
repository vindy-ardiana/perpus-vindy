<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AuthManualController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\user\DashboardUserController;
use App\Http\Controllers\user\KoleksiBukuUserController;
use App\Http\Controllers\user\TransaksiController;
use App\Http\Controllers\user\KoleksiController;
use App\Http\Controllers\user\UlasanController;
use App\Http\Controllers\UlasanAdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('index'); // halaman yg ada "Selamat Datang"
    })->name('index');


Route::get('/dashboard', function () {
    return view('test'); // halaman yg ada "Selamat Datang"
    })->name('dashboard');

// Admin & Petugas: dashboard + master + transaksi + laporan
Route::middleware(['auth', 'admin_or_petugas'])->group(function () {
    Route::get('/dashboard', [BukuController::class, 'count'])->name('dashboard');
    Route::resource('kategori', KategoriController::class);
    Route::resource('penerbit', PenerbitController::class);
    Route::resource('buku', BukuController::class);
    Route::resource('anggota', AnggotaController::class)->parameters(['anggota' => 'anggota']);
    Route::resource('peminjaman', PeminjamanController::class);
    Route::get('/laporan/{id}/detail', [LaporanController::class, 'detail'])->name('laporan.detail');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.admin');
    Route::get('/laporan-buku', [LaporanController::class, 'buku'])->name('laporan.buku');
    Route::get('/laporan-buku/pdf', [LaporanController::class, 'bukuPdf'])->name('laporan.buku.pdf');
    Route::get('/laporan-transaksi', [LaporanController::class, 'transaksi'])->name('laporan.transaksi');
    Route::get('/laporan-transaksi/pdf', [LaporanController::class, 'transaksiPdf'])->name('laporan.transaksi.pdf');
    Route::delete('/laporan/transaksi/{id}', [LaporanController::class, 'destroy'])->name('laporan.transaksi.destroy');
    Route::middleware('admin')->group(function () {
        Route::get('/laporan-user', [LaporanController::class, 'user'])->name('laporan.user');
        Route::get('/laporan-user/pdf', [LaporanController::class, 'userPdf'])->name('laporan.user.pdf');
        Route::resource('user', UserController::class)->only(['index', 'destroy']);
    });

    Route::get('/konfirmasi-peminjaman', [TransaksiController::class, 'indexPeminjaman'])->name('konfirmasi.peminjaman');
    Route::get('/konfirmasi-pengembalian', [TransaksiController::class, 'indexPengembalian'])->name('konfirmasi.pengembalian');
    Route::get('/konfirmasi/tolak/{TransaksiPeminjaman}', [TransaksiController::class, 'tolak'])->name('tolak');
    Route::get('/konfirmasi/{TransaksiPeminjaman}', [TransaksiController::class, 'show'])->name('konfirmasi.show');
    Route::get('/konfirmasi/{TransaksiPeminjaman}/setuju', [TransaksiController::class, 'setuju'])->name('setuju');
    Route::get('/konfirmasi/{TransaksiPeminjaman}/kembalikan', [TransaksiController::class, 'kembali'])->name('konfirmasi.kembali');
    Route::get('/konfirmasi/{transaksi}/setujui-pengembalian', [TransaksiController::class, 'setujuiPengembalian'])->name('konfirmasi.setujui.pengembalian');
    Route::get('/konfirmasi/{transaksi}/tolak-pengembalian', [TransaksiController::class, 'tolakPengembalian'])->name('konfirmasi.tolak.pengembalian');
    Route::get('/ulasan', [UlasanAdminController::class, 'index'])->name('ulasan.index');
    Route::delete('/ulasan/{ulasan}', [UlasanAdminController::class, 'destroy'])->name('ulasan.destroy');

    // Kelola petugas (hanya admin boleh akses, dicek di PetugasController)
    Route::resource('petugas', PetugasController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
});


//USERRRRRRRRRRRRRRRR
Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [DashboardUserController::class, 'index'])->name('user.dashboard');
    Route::get('/user/daftarbuku', [DashboardUserController::class, 'daftarbuku'])->name('user.daftarbuku');
    Route::get('/user/buku/{id}', [DashboardUserController::class, 'detail'])->name('user.buku.detail');
    Route::get('/user/bukti-peminjaman/{transaksi}/pdf', [DashboardUserController::class, 'buktiPeminjamanPdf'])->name('user.bukti.peminjaman.pdf');
    Route::post('/pinjam-buku/{buku}', [TransaksiController::class, 'store'])->name('pinjam.buku');
    Route::post('/user/pengembalian/{transaksi}', [TransaksiController::class, 'ajukanPengembalian'])->name('user.ajukan.pengembalian');
    Route::post('/user/ulasan/{transaksi}', [UlasanController::class, 'store'])->name('user.ulasan.store');
    Route::get('/user/koleksi',[KoleksiBukuUserController::class,'index'])->name('user.koleksi');
    Route::get('/user/koleksi-pribadi', [KoleksiController::class, 'index'])->name('user.koleksi-pribadi');
    Route::get('/user/riwayat',[KoleksiBukuUserController::class,'riwayat'])->name('user.riwayat');
    Route::get('/user/riwayat/pdf', [KoleksiBukuUserController::class, 'riwayatPdf'])->name('user.riwayat.pdf');
    // Route simpan buku ke koleksi
    Route::post('/koleksi/simpan/{buku}', [KoleksiController::class, 'simpan'])->name('koleksi.simpan');
    Route::delete('/koleksi/{koleksi}', [KoleksiController::class, 'hapus'])->name('koleksi.hapus');
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
