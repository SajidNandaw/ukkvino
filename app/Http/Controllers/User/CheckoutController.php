<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Keranjang;
use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;

class CheckoutController extends Controller
{

    /* ================= HALAMAN CHECKOUT ================= */

    public function index()
    {
        $user = Auth::user();

        $keranjang = session()->get('checkout_items');

        if(!$keranjang){
            return redirect()->route('keranjang')->with('error','Pilih produk dulu!');
        }

        $total = session()->get('checkout_total');

        return view('user.checkout', compact('user','keranjang','total'));
    }


    /* ================= STEP 1 ================= */

    public function process(Request $request)
    {
        $user = Auth::user();

        $ids = $request->pilih;

        if(!$ids){
            return redirect()->route('keranjang')
                ->with('error','Pilih minimal 1 produk!');
        }

        $keranjang = Keranjang::where('user_id',$user->id)
            ->whereIn('id',$ids)
            ->get();

        if($keranjang->count() == 0){
            return redirect()->route('keranjang');
        }

        $total = 0;
        $dataCheckout = [];

        foreach($keranjang as $item){

            $produk = Produk::find($item->produk_id);
            if(!$produk) continue;

            $subtotal = $produk->harga * $item->jumlah;

            $dataCheckout[] = [
                'id' => $item->id, // 🔥 FIX UTAMA
                'produk_id' => $item->produk_id,
                'nama' => $produk->nama,
                'harga' => $produk->harga,
                'gambar' => $produk->gambar,
                'jumlah' => $item->jumlah,
                'subtotal' => $subtotal
            ];

            $total += $subtotal;
        }

        session()->put('checkout_items', $dataCheckout);
        session()->put('checkout_total', $total);

        return redirect()->route('checkout');
    }


    /* ================= STEP 2 ================= */

    public function finalCheckout(Request $request)
    {
        $user = Auth::user();

        $keranjang = session()->get('checkout_items');

        if(!$keranjang){
            return redirect()->route('keranjang')
                ->with('error','Session checkout hilang!');
        }

        $total = session()->get('checkout_total');

        if(!$request->metode){
            return back()->with('error','Pilih metode pembayaran!');
        }

        $transaksi = Transaksi::create([
            'user_id' => $user->id,
            'total' => $total,
            'status' => $request->metode == 'cod' ? 'diproses' : 'pending',
            'metode' => $request->metode,
            'tanggal' => now()
        ]);

        foreach($keranjang as $item){

            DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'produk_id' => $item['produk_id'],
                'qty' => $item['jumlah'],
                'subtotal' => $item['subtotal']
            ]);

            $produk = Produk::find($item['produk_id']);

            if($produk){
                $produk->update([
                    'stok' => $produk->stok - $item['jumlah']
                ]);
            }
        }

        // 🔥 HAPUS KERANJANG (FIX)
        $ids = [];

        foreach($keranjang as $item){
            $ids[] = $item['id'];
        }

        Keranjang::where('user_id',$user->id)
            ->whereIn('id',$ids)
            ->delete();

        // hapus session
        session()->forget(['checkout_items','checkout_total']);

        if($request->metode == "transfer"){
            return redirect()->route('pembayaran',[
                'id' => $transaksi->id
            ]);
        }

        return redirect()->route('user.dashboard')
            ->with('success','Pesanan berhasil dibuat (COD)');
    }
}