<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\DetailTransaksi;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
        'user_id',
        'total',
        'status',
        'tanggal',
        'metode'
    ];

    public $timestamps = false;

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    // 🔥 Relasi ke USER (WAJIB biar ga error lagi)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 🔥 Relasi ke DETAIL TRANSAKSI
    public function detail()
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id');
    }
}