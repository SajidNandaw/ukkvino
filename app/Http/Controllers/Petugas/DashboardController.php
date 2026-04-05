<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class DashboardController extends Controller
{

    public function index()
    {

        /* ================= TOTAL DATA ================= */

        $totalUser = User::count();

        $totalTransaksi = DB::table('transaksi')->count();

        $totalProfit = DB::table('transaksi')->sum('total');


        /* ================= RIWAYAT TRANSAKSI ================= */

        $riwayat = DB::table('transaksi')
        ->join('users','transaksi.user_id','=','users.id')
        ->select(
            'transaksi.id',
            'transaksi.tanggal',
            'users.name',
            'transaksi.total',
            'transaksi.status'
        )
        ->orderBy('transaksi.id','desc')
        ->limit(5)
        ->get();


        /* ================= STATISTIK BULANAN ================= */

        $statistik = DB::table('transaksi')
        ->selectRaw('MONTH(tanggal) as bulan, SUM(total) as total')
        ->groupBy(DB::raw('MONTH(tanggal)'))
        ->get();

        $dataBulanan = [];

        foreach($statistik as $row){
            $dataBulanan[$row->bulan] = $row->total;
        }


        /* ================= PRODUK TERLARIS ================= */

        $produkTerlaris = DB::table('detail_transaksi')
        ->join('produk','detail_transaksi.produk_id','=','produk.id')
        ->select(
            'produk.nama',
            DB::raw('SUM(detail_transaksi.qty) as total_terjual')
        )
        ->groupBy('detail_transaksi.produk_id','produk.nama')
        ->orderBy('total_terjual','desc')
        ->limit(5)
        ->get();


        return view('petugas.dashboard',[
            'totalUser'=>$totalUser,
            'totalTransaksi'=>$totalTransaksi,
            'totalProfit'=>$totalProfit,
            'riwayat'=>$riwayat,
            'dataBulanan'=>$dataBulanan,
            'produkTerlaris'=>$produkTerlaris
        ]);

    }

}