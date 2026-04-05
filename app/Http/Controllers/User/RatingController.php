<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ulasan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        // VALIDASI input rating dan produk_id agar tidak NULL dan valid
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        try {
            // SIMPAN atau UPDATE ulasan user untuk produk tersebut
            Ulasan::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'produk_id' => $request->produk_id,
                ],
                [
                    'rating' => $request->rating,
                ]
            );

            // REDIRECT kembali ke halaman sebelumnya dengan pesan sukses
            return back()->with('success', 'Rating berhasil dikirim!');
        } catch (\Exception $e) {
            // Jika ada error, log errornya dan redirect dengan pesan error
            Log::error('Gagal menyimpan rating: ' . $e->getMessage());

            return back()->with('error', 'Terjadi kesalahan saat mengirim rating. Silakan coba lagi.');
        }
    }
}