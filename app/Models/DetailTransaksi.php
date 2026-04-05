<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Transaksi;
use App\Models\Produk;

class DetailTransaksi extends Model
{
    protected $table = 'detail_transaksi';

    protected $fillable = [
        'transaksi_id',
        'produk_id',
        'qty',
        'subtotal'
    ];

    public $timestamps = false;

    /*
    |--------------------------------------------------------------------------
    | RELATION
    |--------------------------------------------------------------------------
    */

    // Relasi ke transaksi
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }

    // Relasi ke produk (INI YANG PENTING BUAT FIX ERROR GAMBAR)
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}