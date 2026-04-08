<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class PublicController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->get('search') ?? '';
        $produk = Produk::query()
            ->when($keyword, fn($q) => $q->where('nama','like',"%$keyword%"))
            ->get();

        $totalCart = 0; // Bisa hitung nanti jika login

        return view('katalog', compact('produk', 'keyword', 'totalCart'));
    }

    public function show($id)
    {
        $produk = Produk::findOrFail($id);

        // 🔥 Tambahkan rating dan jumlah ulasan
        if(method_exists($produk, 'ratings')) {
            $avgRating = round($produk->ratings()->avg('rating') ?? 0);
            $countUlasan = $produk->ratings()->count();
        } else {
            // default jika belum ada relationship ratings
            $avgRating = 0;
            $countUlasan = 0;
        }

        return view('katalog_detail', compact('produk', 'avgRating', 'countUlasan'));
    }
}