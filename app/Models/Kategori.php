<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    //
    protected $guarded = [];

    public function bukus(): HasMany
    {
        return $this->HasMany(Buku::class);
    }
}
