<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

public function index()
{

$p = 'dashboard';

$totalUser = User::count();
$totalProduk = Produk::count();
$totalTransaksi = Transaksi::count();
$totalProfit = Transaksi::sum('total');


$riwayat = Transaksi::join('users','transaksi.user_id','=','users.id')
->select('transaksi.id','transaksi.tanggal','users.name','transaksi.total','transaksi.status')
->orderBy('transaksi.id','desc')
->limit(5)
->get();


$statistik = Transaksi::select(
DB::raw('MONTH(tanggal) as bulan'),
DB::raw('SUM(total) as total')
)
->groupBy(DB::raw('MONTH(tanggal)'))
->pluck('total','bulan');


$terlaris = DetailTransaksi::join('produk','detail_transaksi.produk_id','=','produk.id')
->select('produk.nama',DB::raw('SUM(detail_transaksi.qty) as total_terjual'))
->groupBy('detail_transaksi.produk_id','produk.nama')
->orderByDesc('total_terjual')
->limit(5)
->get();

return view('admin.dashboard',compact(
'p',
'totalUser',
'totalProduk',
'totalTransaksi',
'totalProfit',
'riwayat',
'statistik',
'terlaris'
));

}

}