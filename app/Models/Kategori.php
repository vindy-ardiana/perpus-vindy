<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    //
    protected $guarded = [];

    public function bukus()
    {
        return $this->belongsToMany(Buku::class, 'buku_kategori');
    }
}
