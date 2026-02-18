<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;
use App\Models\TransaksiPeminjaman;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\user\TransaksiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// Helper to reset state
function resetData() {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    Peminjaman::truncate();
    TransaksiPeminjaman::truncate();
    DB::table('peminjaman_bukus')->truncate();
    Buku::truncate();
    Anggota::truncate();
    User::truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
}

function runTests() {
    echo "Starting Verification...\n";
    resetData();

    // Setup Data
    $kategori = \App\Models\Kategori::create(['nama_kategori' => 'Fiksi']);
    $penerbit = \App\Models\Penerbit::create(['nama_penerbit' => 'Gramedia']);
    
    $buku = Buku::create([
        'judul' => 'Test Book',
        'pengarang' => 'Author',
        'tahun_terbit' => 2024,
        'deskripsi' => 'Desc',
        'stok' => 1,
        'kategori_id' => $kategori->id,
        'penerbit_id' => $penerbit->id
    ]);

    $anggota = Anggota::create([
        'nama_anggota' => 'Test Anggota',
        'alamat' => 'Jl. Test No. 1',
        'no_telpon' => '08123456789'
    ]);

    $user = User::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
        'role' => 'user'
    ]);

    echo "Initial Stock: " . $buku->stok . "\n";

    // --- TEST 1: Admin Borrowing ---
    echo "\n--- TEST 1: Admin Borrowing ---\n";
    $controller = new PeminjamanController();
    $request = Request::create('/peminjaman', 'POST', [
        'tgl_peminjaman' => now()->toDateString(),
        'anggota_id' => $anggota->id,
        'buku_ids' => [$buku->id]
    ]);

    $controller->store($request);
    $buku->refresh();
    echo "Stock after Admin borrow: " . $buku->stok . " (Expected: 0)\n";
    
    if ($buku->stok !== 0) {
        throw new Exception("Test 1 Failed: Stock should be 0");
    }

    // Try borrowing again (should fail/throw)
    $response = $controller->store($request);
    // In a real app, this returns a RedirectResponse with errors. 
    // We check stock to confirm it didn't change.
    $buku->refresh();
    echo "Stock after second Admin borrow attempt: " . $buku->stok . " (Expected: 0)\n";
    
    if ($buku->stok !== 0) {
         throw new Exception("Test 1 Failed: Stock should remain 0");
    }
    echo "Confirmed: Second borrow blocked (Stock stayed 0).\n";
    
    // Return book
    $peminjaman = Peminjaman::first();
    $requestReturn = Request::create('/peminjaman/'.$peminjaman->id, 'PUT', [
        'tgl_kembali' => now()->toDateString()
    ]);
    
    $controller->update($requestReturn, $peminjaman);
    $buku->refresh();
    echo "Stock after Admin return: " . $buku->stok . " (Expected: 1)\n";
    
    if ($buku->stok !== 1) {
        throw new Exception("Test 1 Failed: Stock should be 1 after return");
    }


    // --- TEST 2: User Borrowing ---
    echo "\n--- TEST 2: User Borrowing ---\n";
    Auth::login($user);
    $transaksiController = new TransaksiController();

    // Borrow
    $transaksiController->store($buku);
    $buku->refresh();
    echo "Stock after User borrow request: " . $buku->stok . " (Expected: 0)\n";
    
    if ($buku->stok !== 0) {
         throw new Exception("Test 2 Failed: Stock should be 0 immediately after user request");
    }

    // Reject
    $transaksi = TransaksiPeminjaman::where('user_id', $user->id)->first();
    $transaksiController->tolak($transaksi);
    $buku->refresh();
    echo "Stock after Admin reject: " . $buku->stok . " (Expected: 1)\n";

    if ($buku->stok !== 1) {
         throw new Exception("Test 2 Failed: Stock should be 1 after rejection");
    }
    
    // Borrow again
    $transaksiController->store($buku);
    $buku->refresh();
    echo "Stock after User borrow request (2): " . $buku->stok . " (Expected: 0)\n";

    // Approve
    $transaksi = TransaksiPeminjaman::where('user_id', $user->id)->where('status', 'Proses')->first(); // New one
    $transaksiController->setuju($transaksi);
    $buku->refresh();
    echo "Stock after Admin approve: " . $buku->stok . " (Expected: 0)\n";

    if ($buku->stok !== 0) {
         throw new Exception("Test 2 Failed: Stock should remain 0 after approval");
    }

    // Return
    $transaksiController->kembali($transaksi);
    $buku->refresh();
    echo "Stock after User return: " . $buku->stok . " (Expected: 1)\n";

    if ($buku->stok !== 1) {
         throw new Exception("Test 2 Failed: Stock should be 1 after return");
    }

    echo "\nALL TESTS PASSED.\n";
}

runTests();
