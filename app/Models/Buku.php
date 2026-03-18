<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Buku extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function kategoris()
    {
        return $this->belongsToMany(Kategori::class, 'buku_kategori');
    }

    public function penerbit(): BelongsTo
    {
        return $this->belongsTo(Penerbit::class);
    }

    public function peminjaman(){
        return $this->belongsToMany(Peminjaman::class, 'peminjaman_bukus');
    }

    public function ulasans()
    {
        return $this->hasManyThrough(
            Ulasan::class,
            TransaksiPeminjaman::class,
            'buku_id',
            'transaksi_peminjaman_id',
            'id',
            'id'
        );
    }

    public function getRataRataRatingAttribute(): float
    {
        return (float) $this->ulasans()->avg('rating') ?: 0;
    }
}
