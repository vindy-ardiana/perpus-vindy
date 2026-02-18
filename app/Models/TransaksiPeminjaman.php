<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiPeminjaman extends Model
{
    
   protected $table= 'transaksi_peminjamen';
   protected $guarded = [];

   
   public function buku(){
    return $this->belongsTo(Buku::class, 'buku_id');
   }
   
   public function user(){
    return $this->belongsTo(User::class, 'user_id');
   }

}
