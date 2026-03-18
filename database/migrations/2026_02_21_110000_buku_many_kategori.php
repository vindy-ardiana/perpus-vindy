<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku_kategori', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buku_id')->constrained('bukus')->onDelete('cascade');
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['buku_id', 'kategori_id']);
        });

        // Migrate existing kategori_id ke pivot
        $bukus = DB::table('bukus')->whereNotNull('kategori_id')->get();
        foreach ($bukus as $b) {
            DB::table('buku_kategori')->insert([
                'buku_id' => $b->id,
                'kategori_id' => $b->kategori_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Schema::table('bukus', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->dropColumn('kategori_id');
        });
    }

    public function down(): void
    {
        Schema::table('bukus', function (Blueprint $table) {
            $table->foreignId('kategori_id')->nullable()->after('penerbit_id')->constrained('kategoris')->onDelete('restrict');
        });
        $pivot = DB::table('buku_kategori')->get();
        foreach ($pivot as $p) {
            DB::table('bukus')->where('id', $p->buku_id)->update(['kategori_id' => $p->kategori_id]);
        }
        Schema::dropIfExists('buku_kategori');
    }
};
