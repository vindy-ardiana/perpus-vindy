<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi_peminjamen', function (Blueprint $table) {
            $table->unsignedTinyInteger('lama_pinjam_hari')->default(7)->after('tgl_peminjaman');
        });
    }

    public function down(): void
    {
        Schema::table('transaksi_peminjamen', function (Blueprint $table) {
            $table->dropColumn('lama_pinjam_hari');
        });
    }
};
