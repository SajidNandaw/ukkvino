<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaksi;

class RiwayatController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $riwayat = Transaksi::join('detail_transaksi','transaksi.id','=','detail_transaksi.transaksi_id')
            ->join('produk','detail_transaksi.produk_id','=','produk.id')
            ->where('transaksi.user_id', $user->id)
            ->select(
                'transaksi.*',
                'detail_transaksi.qty',
                'produk.nama',
                'produk.gambar'
            )
            ->latest()
            ->get();

        // 🔥 NORMALISASI STATUS (BIAR UI SELALU BENAR)
        foreach ($riwayat as $row) {

            $status = strtolower($row->status);

            if ($status == 'menunggu') $status = 'pending';
            elseif ($status == 'pending') $status = 'pending';

            elseif ($status == 'proses') $status = 'dibayar';
            elseif ($status == 'dibayar') $status = 'dibayar';

            elseif ($status == 'kirim') $status = 'dikirim';
            elseif ($status == 'dikirim') $status = 'dikirim';

            elseif ($status == 'selesai') $status = 'selesai';

            elseif ($status == 'batal' || $status == 'dibatalkan') $status = 'dibatalkan';

            else $status = 'pending'; // 🔥 fallback biar gak "tidak diketahui"

            $row->status = $status;
        }

        return view('user.riwayat', compact('riwayat'));
    }


    public function detail($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $detail = \App\Models\DetailTransaksi::join('produk','detail_transaksi.produk_id','=','produk.id')
            ->where('transaksi_id', $id)
            ->select('detail_transaksi.*','produk.nama','produk.gambar')
            ->get();

        return view('user.detail_pesanan', compact('transaksi','detail'));
    }


    public function batal($id)
    {
        $user = Auth::user();

        $transaksi = Transaksi::where('user_id', $user->id)
            // 🔥 AMBIL SEMUA STATUS YANG MASIH BOLEH DIBATALIN
            ->whereNotIn('status', ['selesai','dibatalkan'])
            ->findOrFail($id);

        $transaksi->update([
            'status' => 'dibatalkan'
        ]);

        return redirect()->route('user.riwayat')
            ->with('success','Pesanan berhasil dibatalkan');
    }
}