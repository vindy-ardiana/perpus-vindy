<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi_peminjamen', function (Blueprint $table) {
            $table->id();
            $table->string('no_peminjaman');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('buku_id')->constrained('bukus')->onDelete('restrict');  
            $table->date('tgl_peminjaman');
            $table->date('tgl_kembali')->nullable();
            $table->enum('status_pengembalian', ['Dipinjam', 'Dikembalikan'])->default('Dipinjam');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_peminjamen');
    }
};
