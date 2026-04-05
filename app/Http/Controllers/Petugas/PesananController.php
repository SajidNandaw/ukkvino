<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;

class PesananController extends Controller
{
    /* =========================
       LIST PESANAN + RIWAYAT
    ========================= */
    public function index()
    {
        // Pesanan Aktif (pending, dibayar, diproses, dikirim)
        $pesanan = Transaksi::with('user')
            ->whereIn('status', ['pending','dibayar','diproses','dikirim'])
            ->orderBy('id','desc')
            ->get();

        // Riwayat Pesanan (selesai & batal)
        $riwayat = Transaksi::with('user')
            ->whereIn('status', ['selesai','batal'])
            ->orderBy('id','desc')
            ->get();

        return view('petugas.pesanan', compact('pesanan','riwayat'));
    }

    /* =========================
       DETAIL PESANAN
    ========================= */
    public function detail($id)
    {
        $transaksi = Transaksi::with('user')->findOrFail($id);

        $detail = DetailTransaksi::with('produk')
            ->where('transaksi_id', $id)
            ->get();

        return view('petugas.detail-pesanan', compact('transaksi','detail'));
    }

    /* =========================
       PROSES PESANAN (optional)
       Untuk ubah dari 'dibayar' → 'diproses'
    ========================= */
    public function proses($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if($transaksi->status == 'dibayar'){
            $transaksi->update(['status' => 'diproses']);
            return back()->with('success','Pesanan berhasil diproses');
        }

        return back()->with('error','Pesanan tidak bisa diproses');
    }

    /* =========================
       KIRIM PESANAN
    ========================= */
    public function kirim($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if($transaksi->status == 'diproses' || $transaksi->status == 'dibayar'){
            $transaksi->update(['status' => 'dikirim']);
            return back()->with('success','Pesanan berhasil dikirim');
        }

        return back()->with('error','Pesanan tidak bisa dikirim');
    }

    /* =========================
       SELESAIKAN PESANAN
    ========================= */
    public function selesai($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        if($transaksi->status == 'dikirim'){
            $transaksi->update(['status' => 'selesai']);
            return redirect()->route('petugas.pesanan.index')
                ->with('success','Pesanan berhasil diselesaikan');
        }

        return back()->with('error','Pesanan belum dikirim, tidak bisa diselesaikan');
    }
}