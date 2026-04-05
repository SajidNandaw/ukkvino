<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Keranjang;
use App\Models\Ulasan; // 🔥 TAMBAH INI
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{

    public function detail($id)
    {
        $produk = Produk::findOrFail($id);

        $user_id = Auth::id();

        $totalCart = Keranjang::where('user_id',$user_id)
                        ->sum('jumlah');

        // 🔥 AMBIL DATA RATING
        $avgRating = Ulasan::where('produk_id', $id)->avg('rating') ?? 0;
        $countUlasan = Ulasan::where('produk_id', $id)->count();

        return view('user.detail_produk',[
            'produk' => $produk,
            'totalCart' => $totalCart,
            'avgRating' => $avgRating,
            'countUlasan' => $countUlasan
        ]);
    }


    public function tambahKeranjang(Request $request)
    {
        $user_id = Auth::id();
        $produk_id = $request->produk_id;

        $cek = Keranjang::where('user_id',$user_id)
                ->where('produk_id',$produk_id)
                ->first();

        if($cek){
            $cek->increment('jumlah');
        }else{
            Keranjang::create([
                'user_id'=>$user_id,
                'produk_id'=>$produk_id,
                'jumlah'=>1
            ]);
        }

        return redirect()->route('keranjang')
                ->with('success','Produk berhasil dimasukkan ke keranjang');
    }

}