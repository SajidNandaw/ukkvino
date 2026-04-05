<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{

protected $table = 'keranjang';

public $timestamps = false;

protected $fillable = [
'user_id',
'produk_id',
'jumlah'
];

}