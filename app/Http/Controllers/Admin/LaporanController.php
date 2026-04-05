<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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


        $totalTerjual = DB::table('detail_transaksi')
        ->sum('qty');


        return view('admin.laporan.index',compact(
            'penjualan',
            'stok',
            'totalTerjual'
        ));
    }


    public function chartData()
    {

        $data = DB::table('transaksi')
        ->select(
            DB::raw('DATE(tanggal) as tgl'),
            DB::raw('SUM(total) as total')
        )
        ->groupBy(DB::raw('DATE(tanggal)'))
        ->orderBy('tgl','ASC')
        ->get();


        $labels = [];
        $values = [];

        foreach($data as $row){
            $labels[] = $row->tgl;
            $values[] = $row->total;
        }


        return response()->json([
            'labels'=>$labels,
            'data'=>$values
        ]);

    }


    public function download($type)
    {

        $filename = $type.".csv";

        $headers = [
            "Content-type"=>"text/csv",
            "Content-Disposition"=>"attachment; filename=$filename",
        ];

        $callback = function() use ($type){

            $output = fopen('php://output','w');

            if($type == "penjualan"){

                fputcsv($output,['ID','Tanggal','Pembeli','Total']);

                $data = DB::table('transaksi')
                ->join('users','transaksi.user_id','=','users.id')
                ->select('transaksi.id','transaksi.tanggal','users.name','transaksi.total')
                ->get();

                foreach($data as $row){
                    fputcsv($output,(array)$row);
                }
            }


            if($type == "stok"){

                fputcsv($output,['Produk','Stok']);

                $data = DB::table('produk')->select('nama','stok')->get();

                foreach($data as $row){
                    fputcsv($output,(array)$row);
                }
            }


            if($type == "grafik"){

                fputcsv($output,['Tanggal','Total']);

                $data = DB::table('transaksi')
                ->select(
                    DB::raw('DATE(tanggal) as tanggal'),
                    DB::raw('SUM(total) as total')
                )
                ->groupBy(DB::raw('DATE(tanggal)'))
                ->get();

                foreach($data as $row){
                    fputcsv($output,(array)$row);
                }

            }

            fclose($output);
        };

        return response()->stream($callback,200,$headers);

    }

}