<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Keranjang;
use App\Models\Produk;

class KeranjangController extends Controller
{

public function index()
{

$user_id = Auth::id();

$keranjang = Keranjang::join('produk','keranjang.produk_id','=','produk.id')
            ->where('keranjang.user_id',$user_id)
            ->select(
                'keranjang.id as keranjang_id',
                'keranjang.jumlah',
                'produk.nama',
                'produk.harga',
                'produk.gambar'
            )
            ->get();

$totalBelanja = 0;

foreach($keranjang as $item){
$totalBelanja += $item->harga * $item->jumlah;
}

return view('user.keranjang',[
'keranjang'=>$keranjang,
'totalBelanja'=>$totalBelanja
]);

}

public function tambah($id)
{

$item = Keranjang::find($id);

$item->jumlah += 1;
$item->save();

return redirect()->route('keranjang');

}

public function kurang($id)
{

$item = Keranjang::find($id);

if($item->jumlah > 1){
$item->jumlah -= 1;
$item->save();
}

return redirect()->route('keranjang');

}

public function hapus($id)
{

Keranjang::destroy($id);

return redirect()->route('keranjang');

}

}