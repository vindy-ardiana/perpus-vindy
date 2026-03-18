<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    protected $table = 'ulasans';
    protected $guarded = [];

    public function transaksiPeminjaman()
    {
        return $this->belongsTo(TransaksiPeminjaman::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
