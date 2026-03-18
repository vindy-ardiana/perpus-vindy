<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TransaksiPeminjaman extends Model
{
    public const MASA_PINJAM_HARI = 7;

    protected $table = 'transaksi_peminjamen';
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'tgl_peminjaman' => 'date',
            'tgl_kembali' => 'date',
            'tgl_pengembalian_rencana' => 'date',
        ];
    }

    /** Batas tanggal pengembalian (tgl_pengembalian_rencana atau tgl_peminjaman + lama_pinjam_hari) */
    public function getBatasKembaliAttribute(): Carbon
    {
        if ($this->tgl_pengembalian_rencana) {
            return $this->tgl_pengembalian_rencana->copy();
        }
        $hari = (int) ($this->lama_pinjam_hari ?? self::MASA_PINJAM_HARI);
        $hari = max(1, min(7, $hari));
        return $this->tgl_peminjaman->copy()->addDays($hari);
    }

    /** Apakah peminjaman ini terlambat (sudah lewat batas dan belum dikembalikan) */
    public function isTerlambat(): bool
    {
        if ($this->status_pengembalian === 'Dikembalikan') {
            return $this->tgl_kembali && $this->tgl_kembali->gt($this->batas_kembali);
        }
        return $this->status === 'Setuju' && now()->startOfDay()->gt($this->batas_kembali);
    }

   
   public function buku(){
    return $this->belongsTo(Buku::class, 'buku_id');
   }
   
   public function user(){
    return $this->belongsTo(User::class, 'user_id');
   }

   public function ulasan()
   {
       return $this->hasOne(Ulasan::class);
   }
}
