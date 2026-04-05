<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Transaksi;

class PageController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HELPER CART
    |--------------------------------------------------------------------------
    */
    private function getCartCount()
    {
        return DB::table('keranjang')
            ->where('user_id', Auth::id())
            ->sum('jumlah');
    }

    /*
    |--------------------------------------------------------------------------
    | TENTANG KAMI
    |--------------------------------------------------------------------------
    */
    public function tentang()
    {
        $totalCart = $this->getCartCount();

        return view('user.tentang_kami', compact('totalCart'));
    }

    /*
    |--------------------------------------------------------------------------
    | CARA BELANJA
    |--------------------------------------------------------------------------
    */
    public function caraBelanja()
    {
        $totalCart = $this->getCartCount();

        return view('user.cara-belanja', compact('totalCart'));
    }

    /*
    |--------------------------------------------------------------------------
    | METODE PEMBAYARAN
    |--------------------------------------------------------------------------
    */
    public function metodePembayaran($id = null)
    {
        $totalCart = $this->getCartCount();
        $data = null;

        if ($id) {
            $data = Transaksi::where('id', $id)
                ->where('user_id', Auth::id())
                ->first();
        }

        return view('user.metode_pembayaran', compact('data','totalCart'));
    }

    /*
    |--------------------------------------------------------------------------
    | PENGIRIMAN
    |--------------------------------------------------------------------------
    */
    public function pengiriman()
    {
        $totalCart = $this->getCartCount();

        return view('user.pengiriman', compact('totalCart'));
    }

    /*
    |--------------------------------------------------------------------------
    | SYARAT & KETENTUAN
    |--------------------------------------------------------------------------
    */
    public function syarat()
    {
        $totalCart = $this->getCartCount();

        return view('user.syarat_ketentuan', compact('totalCart'));
    }
}