<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Ulasan;

class PembayaranController extends Controller
{

    /* ==========================
       HALAMAN PEMBAYARAN
    ========================== */
    public function index($id)
    {
        $user = Auth::user();

        $transaksi = Transaksi::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$transaksi) {
            abort(404, 'Transaksi tidak ditemukan');
        }

        $produk = DetailTransaksi::join('produk', 'detail_transaksi.produk_id', '=', 'produk.id')
            ->where('detail_transaksi.transaksi_id', $id)
            ->select(
                'detail_transaksi.*',
                'produk.nama',
                'produk.gambar'
            )
            ->get();

        $total_produk = 0;

        foreach ($produk as $p) {
            $total_produk += $p->subtotal;
        }

        return view('user.pembayaran', [
            'data' => $transaksi,
            'produk' => $produk,
            'total_produk' => $total_produk
        ]);
    }


    /* ==========================
       HALAMAN DETAIL PESANAN + RATING
    ========================== */
    public function detail($id)
    {
        $transaksi = Transaksi::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $detail = DetailTransaksi::join('produk', 'detail_transaksi.produk_id', '=', 'produk.id')
            ->where('detail_transaksi.transaksi_id', $id)
            ->select(
                'detail_transaksi.*',
                'produk.nama',
                'produk.gambar'
            )
            ->get();

        // Ambil semua rating user untuk produk di transaksi ini
        $produkIds = $detail->pluck('produk_id')->toArray();

        $ulasan = Ulasan::where('user_id', Auth::id())
            ->whereIn('produk_id', $produkIds)
            ->get()
            ->keyBy('produk_id'); // keyBy supaya bisa pakai $ulasan->has($item->produk_id) di Blade

        return view('user.detail_pesanan', compact('transaksi', 'detail', 'ulasan'));
    }


    /* ==========================
       UPLOAD BUKTI PEMBAYARAN
    ========================== */
    public function upload(Request $request)
    {
        $request->validate([
            'transaksi_id' => 'required',
            'bukti' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $transaksi = Transaksi::where('id', $request->transaksi_id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$transaksi) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan');
        }

        /* ================= UPLOAD FILE ================= */
        $file = $request->file('bukti');
        $nama_file = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('bukti_pembayaran'), $nama_file);

        /* ================= UPDATE TRANSAKSI ================= */
        $transaksi->update([
            'bukti' => $nama_file,
            'status' => 'dibayar'
        ]);

        return redirect()->route('user.riwayat')
            ->with('success', 'Bukti pembayaran berhasil diupload');
    }
}