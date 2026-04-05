<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Produk;

class Ulasan extends Model
{
    protected $table = 'ulasan';

    protected $fillable = [
        'user_id',
        'produk_id',
        'rating',
        'komentar'
    ];

    /* =========================
       RELASI
    ========================= */
    
    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Produk
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}