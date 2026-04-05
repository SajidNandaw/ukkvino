<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Keranjang;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $keyword = $request->search;

        if ($keyword) {
            $produk = Produk::where('nama','like',"%$keyword%")
                ->orWhere('deskripsi','like',"%$keyword%")
                ->orderBy('id','desc')
                ->get();
        } else {
            $produk = Produk::orderBy('id','desc')->get();
        }

        $user_id = Auth::id();

        $totalCart = Keranjang::where('user_id',$user_id)->sum('jumlah');

        return view('user.dashboard',[
            'produk'=>$produk,
            'keyword'=>$keyword,
            'totalCart'=>$totalCart
        ]);
    }
}