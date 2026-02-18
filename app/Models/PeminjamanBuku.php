<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeminjamanBuku extends Model
{
   protected $table= 'peminjaman_bukus';
   protected $guarded = [];

   public function buku(){
    return $this->belongsTo(Buku::class, 'buku_id');
   }
   public function peminjaman() {
    return $this->belongsTo(Peminjaman::class,'peminjaman_id');
   }

}
