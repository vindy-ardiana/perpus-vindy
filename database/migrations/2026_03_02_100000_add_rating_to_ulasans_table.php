<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ulasans', function (Blueprint $table) {
            $table->unsignedTinyInteger('rating')->default(0)->after('isi_ulasan')->comment('1-5');
        });
    }

    public function down(): void
    {
        Schema::table('ulasans', function (Blueprint $table) {
            $table->dropColumn('rating');
        });
    }
};
