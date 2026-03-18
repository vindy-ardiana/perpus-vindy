<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom tgl_pengembalian_rencana (tanggal pengembalian dari form user)
        Schema::table('transaksi_peminjamen', function (Blueprint $table) {
            $table->date('tgl_pengembalian_rencana')->nullable()->after('tgl_peminjaman');
        });

        // Modifikasi enum status_pengembalian: tambah MenungguPengembalian
        DB::statement("ALTER TABLE transaksi_peminjamen MODIFY COLUMN status_pengembalian ENUM('Dipinjam', 'MenungguPengembalian', 'Dikembalikan') DEFAULT 'Dipinjam'");

        // Tabel ulasan
        Schema::create('ulasans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_peminjaman_id')->constrained('transaksi_peminjamen')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('isi_ulasan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ulasans');

        Schema::table('transaksi_peminjamen', function (Blueprint $table) {
            $table->dropColumn('tgl_pengembalian_rencana');
        });

        DB::statement("ALTER TABLE transaksi_peminjamen MODIFY COLUMN status_pengembalian ENUM('Dipinjam', 'Dikembalikan') DEFAULT 'Dipinjam'");
    }
};
