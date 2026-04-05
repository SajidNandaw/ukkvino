<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{

    public function index()
    {

        $penjualan = DB::table('transaksi')
        ->join('users','transaksi.user_id','=','users.id')
        ->select(
            'transaksi.id',
            'transaksi.tanggal',
            'transaksi.total',
            'users.name as pembeli'
        )
        ->orderBy('transaksi.id','desc')
        ->limit(5)
        ->get();


        $stok = DB::table('produk')
        ->select('nama','stok')
        ->orderBy('id','desc')
        ->limit(5)
        ->get();


        $totalTerjual = DB::table('detail_transaksi')->sum('qty');


        return view('petugas.laporan.index',compact(
            'penjualan',
            'stok',
            'totalTerjual'
        ));

    }

}