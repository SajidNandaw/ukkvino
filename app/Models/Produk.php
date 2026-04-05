<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';

    public $timestamps = false;

    protected $fillable = [
        'nama',
        'deskripsi',
        'harga',
        'stok',
        'gambar'
    ];

    /* =========================
       RELASI KE ULASAN
    ========================= */
    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'produk_id');
    }

    /* =========================
       RATA-RATA RATING
    ========================= */
    public function getRatingAttribute()
    {
        return round($this->ulasan()->avg('rating'), 1);
    }

    /* =========================
       TOTAL ULASAN
    ========================= */
    public function getTotalUlasanAttribute()
    {
        return $this->ulasan()->count();
    }
}