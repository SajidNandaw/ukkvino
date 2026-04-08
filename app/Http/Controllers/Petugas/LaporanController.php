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

    public function download($type)
{
    // contoh sederhana: cek type dan generate file
    if($type == 'penjualan'){
        // logika generate laporan penjualan, misal CSV atau PDF
        return response()->download(storage_path('app/laporan_penjualan.xlsx'));
    } elseif($type == 'stok'){
        return response()->download(storage_path('app/laporan_stok.xlsx'));
    } elseif ($type == 'grafik') {
        return response()->download(storage_path('app/laporan_grafik.xlsx'));
    } else {
        abort(404, 'Tipe laporan tidak ditemukan');
    }
}


}