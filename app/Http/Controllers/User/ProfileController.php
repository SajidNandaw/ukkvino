<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Keranjang;

class ProfileController extends Controller
{

    /* ================= HALAMAN PROFIL ================= */

    public function index()
    {
        $user = Auth::user();

        $totalCart = Keranjang::where('user_id',$user->id)->sum('jumlah');

        return view('user.profile', compact('user','totalCart'));
    }


    /* ================= EDIT PROFIL ================= */

    public function edit()
    {
        $user = Auth::user();

        $totalCart = Keranjang::where('user_id',$user->id)->sum('jumlah');

        return view('user.edit_profile', compact('user','totalCart'));
    }


    /* ================= UPDATE PROFIL ================= */

    public function update(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'alamat' => 'required'
        ]);

        /** @var User $user */
        $user = Auth::user();

        $user->update([
            'name' => $request->name,
            'alamat' => $request->alamat
        ]);

        return redirect()->route('user.profile')
        ->with('success','Profil berhasil diperbarui');
    }


    /* ================= HALAMAN GANTI PASSWORD ================= */

    public function password()
    {
        $user = Auth::user();

        $totalCart = Keranjang::where('user_id',$user->id)->sum('jumlah');

        return view('user.password', compact('user','totalCart'));
    }


    /* ================= UPDATE PASSWORD ================= */

    public function passwordUpdate(Request $request)
    {

        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:6',
            'konfirmasi_password' => 'required|same:password_baru'
        ]);

        /** @var User $user */
        $user = Auth::user();

        if(!Hash::check($request->password_lama, $user->password)){
            return back()->with('error','Password lama salah');
        }

        $user->update([
            'password' => Hash::make($request->password_baru)
        ]);

        return redirect()->route('user.profile')
        ->with('success','Password berhasil diganti');
    }


    /* ================= RIWAYAT PESANAN ================= */

    public function riwayat()
    {
        $user = Auth::user();

        $totalCart = Keranjang::where('user_id',$user->id)->sum('jumlah');

        $riwayat = DB::table('transaksi')
            ->join('detail_transaksi','transaksi.id','=','detail_transaksi.transaksi_id')
            ->join('produk','detail_transaksi.produk_id','=','produk.id')
            ->where('transaksi.user_id',$user->id)
            ->select(
    'transaksi.id',
    'transaksi.tanggal',
    'transaksi.total',
    'transaksi.status',
    'transaksi.metode',
    'produk.nama',
    'produk.gambar',
    'detail_transaksi.qty'
)
            ->orderBy('transaksi.tanggal','desc')
            ->get();

        return view('user.riwayat', compact('riwayat','totalCart'));
    }


    /* ================= DETAIL PESANAN ================= */

    public function detailPesanan($id)
    {

        $user = Auth::user();

        $totalCart = Keranjang::where('user_id',$user->id)->sum('jumlah');

        /* ================= DATA TRANSAKSI ================= */

        $transaksi = DB::table('transaksi')
            ->join('users','transaksi.user_id','=','users.id')
            ->where('transaksi.id',$id)
            ->where('transaksi.user_id',$user->id)
            ->select(
                'transaksi.*',
                'users.name',
                'users.alamat'
            )
            ->first();

        if(!$transaksi){
            return redirect()->route('user.riwayat');
        }

        /* ================= DETAIL PRODUK ================= */

        $detail = DB::table('detail_transaksi')
            ->join('produk','detail_transaksi.produk_id','=','produk.id')
            ->where('detail_transaksi.transaksi_id',$id)
            ->select(
                'detail_transaksi.*',
                'produk.nama',
                'produk.gambar'
            )
            ->get();

        return view('user.detail_pesanan',[
            'transaksi' => $transaksi,
            'detail' => $detail,
            'totalCart' => $totalCart
        ]);
    }

}