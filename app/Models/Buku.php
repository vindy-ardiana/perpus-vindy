<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Buku extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    public function penerbit(): BelongsTo
    {
        return $this->belongsTo(Penerbit::class);
    }

    public function peminjaman(){
        return $this->belongsToMany(Peminjaman::class, 'peminjaman_bukus');
    }

    
}
