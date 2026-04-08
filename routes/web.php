<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;

/* ADMIN */
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\PetugasController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LaporanController;

/* PETUGAS */
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\Petugas\ProdukController as PetugasProdukController;
use App\Http\Controllers\Petugas\UserController as PetugasUserController;
use App\Http\Controllers\Petugas\LaporanController as PetugasLaporanController;
use App\Http\Controllers\Petugas\PesananController;

/* USER */
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\ProdukController as UserProdukController;
use App\Http\Controllers\User\KeranjangController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\PembayaranController;
use App\Http\Controllers\User\RiwayatController;
use App\Http\Controllers\User\RatingController;
use App\Http\Controllers\PageController;

/* PUBLIC KATALOG */
use App\Http\Controllers\PublicController;

/*
|--------------------------------------------------------------------------
| HALAMAN AWAL / KATALOG PUBLIK
|--------------------------------------------------------------------------
| Semua orang yang buka website langsung melihat katalog
*/
Route::get('/', [PublicController::class, 'index'])->name('public.katalog');
Route::get('/produk/{id}', [PublicController::class, 'show'])->name('produk.detail'); // ✅ Tambahan untuk detail.blade.php

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::controller(AuthController::class)->group(function () {
    Route::get('/login','login')->name('login');
    Route::post('/login','loginPost')->name('login.post');

    Route::get('/register','register')->name('register');
    Route::post('/register','registerPost')->name('register.post');

    Route::post('/logout','logout')->name('logout');
});

/*
|--------------------------------------------------------------------------
| REDIRECT DASHBOARD
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $user = Auth::user();

    if($user->role == 'admin') return redirect()->route('admin.dashboard');
    if($user->role == 'petugas') return redirect()->route('petugas.dashboard');

    return redirect()->route('user.dashboard');
})->middleware('auth');

/*
|--------------------------------------------------------------------------
| ROUTE SETELAH LOGIN
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->group(function () {

        Route::get('/dashboard',[AdminDashboardController::class,'index'])->name('admin.dashboard');

        /* PRODUK */
        Route::get('/produk',[ProdukController::class,'index'])->name('admin.produk.index');
        Route::get('/produk/tambah',[ProdukController::class,'create'])->name('admin.produk.create');
        Route::post('/produk/tambah',[ProdukController::class,'store'])->name('admin.produk.store');
        Route::get('/produk/edit/{id}',[ProdukController::class,'edit'])->name('admin.produk.edit');
        Route::post('/produk/update/{id}',[ProdukController::class,'update'])->name('admin.produk.update');
        Route::get('/produk/hapus/{id}',[ProdukController::class,'destroy'])->name('admin.produk.destroy');

        /* PETUGAS */
        Route::get('/petugas',[PetugasController::class,'index'])->name('admin.petugas.index');
        Route::get('/petugas/tambah',[PetugasController::class,'create'])->name('admin.petugas.create');
        Route::post('/petugas/tambah',[PetugasController::class,'store'])->name('admin.petugas.store');
        Route::get('/petugas/edit/{id}',[PetugasController::class,'edit'])->name('admin.petugas.edit');
        Route::post('/petugas/update/{id}',[PetugasController::class,'update'])->name('admin.petugas.update');
        Route::get('/petugas/hapus/{id}',[PetugasController::class,'destroy'])->name('admin.petugas.destroy');

        /* USER */
        Route::get('/user',[UserController::class,'index'])->name('admin.user.index');
        Route::get('/user/edit/{id}',[UserController::class,'edit'])->name('admin.user.edit');
        Route::post('/user/update/{id}',[UserController::class,'update'])->name('admin.user.update');
        Route::delete('/user/hapus/{id}',[UserController::class,'destroy'])->name('admin.user.destroy');

        /* NONAKTIF / AKTIFKAN USER */
        Route::post('/user/nonaktif/{id}',[UserController::class,'nonaktif'])->name('admin.user.nonaktif');
        Route::post('/user/aktifkan/{id}',[UserController::class,'aktifkan'])->name('admin.user.aktifkan');

        /* BACKUP */
        Route::get('/backup',[BackupController::class,'index'])->name('admin.backup');
        Route::get('/backup/restore/{id}',[BackupController::class,'restore'])->name('admin.backup.restore');
        Route::get('/backup/download/{id}',[BackupController::class,'download'])->name('admin.backup.download');

        /* LAPORAN */
        Route::get('/laporan',[LaporanController::class,'index'])->name('admin.laporan.index');
        Route::get('/laporan/chart-data',[LaporanController::class,'chartData'])->name('admin.laporan.chart');
        Route::get('/laporan/download/{type}',[LaporanController::class,'download'])->name('admin.laporan.download');
    });

    /*
    |--------------------------------------------------------------------------
    | PETUGAS
    |--------------------------------------------------------------------------
    */
    Route::prefix('petugas')->group(function () {

        Route::get('/dashboard',[PetugasDashboardController::class,'index'])->name('petugas.dashboard');

        /* PRODUK */
        Route::get('/produk',[PetugasProdukController::class,'index'])->name('petugas.produk.index');
        Route::get('/produk/tambah',[PetugasProdukController::class,'create'])->name('petugas.produk.create');
        Route::post('/produk/tambah',[PetugasProdukController::class,'store'])->name('petugas.produk.store');
        Route::get('/produk/edit/{id}',[PetugasProdukController::class,'edit'])->name('petugas.produk.edit');
        Route::post('/produk/update/{id}',[PetugasProdukController::class,'update'])->name('petugas.produk.update');
        Route::get('/produk/hapus/{id}',[PetugasProdukController::class,'destroy'])->name('petugas.produk.destroy');

        /* USER */
        Route::get('/user',[PetugasUserController::class,'index'])->name('petugas.user.index');
        Route::get('/user/edit/{id}', [PetugasUserController::class,'edit'])->name('petugas.user.edit');
        Route::post('/user/update/{id}', [PetugasUserController::class,'update'])->name('petugas.user.update');
        Route::post('/user/nonaktif/{id}',[PetugasUserController::class,'nonaktif'])->name('petugas.user.nonaktif');

        /* PESANAN */
        Route::get('/pesanan',[PesananController::class,'index'])->name('petugas.pesanan.index');
        Route::get('/pesanan/detail/{id}',[PesananController::class,'detail'])->name('petugas.pesanan.detail');
        Route::post('/pesanan/proses/{id}',[PesananController::class,'proses'])->name('petugas.pesanan.proses');
        Route::post('/pesanan/kirim/{id}',[PesananController::class,'kirim'])->name('petugas.pesanan.kirim');
        Route::post('/pesanan/selesai/{id}',[PesananController::class,'selesai'])->name('petugas.pesanan.selesai');

        /* LAPORAN */
        Route::get('/laporan',[PetugasLaporanController::class,'index'])->name('petugas.laporan.index');
        Route::get('/laporan/chart-data',[PetugasLaporanController::class,'chartData'])->name('petugas.laporan.chart');
        Route::get('/laporan/download/{type}',[PetugasLaporanController::class,'download'])->name('petugas.laporan.download');
    });

    /*
    |--------------------------------------------------------------------------
    | USER
    |--------------------------------------------------------------------------
    */
    Route::prefix('user')->group(function () {

        Route::get('/dashboard',[UserDashboardController::class,'index'])->name('user.dashboard');

        Route::post('/rating/store', [RatingController::class, 'store'])->name('rating.store');

        /* PRODUK */
        Route::get('/produk',[UserProdukController::class,'index'])->name('user.produk');
        Route::get('/produk/{id}',[UserProdukController::class,'detail'])->name('user.produk.detail');

        /* KERANJANG */
        Route::get('/keranjang',[KeranjangController::class,'index'])->name('keranjang');
        Route::post('/keranjang/add',[UserProdukController::class,'tambahKeranjang'])->name('keranjang.add');
        Route::get('/keranjang/tambah/{id}',[KeranjangController::class,'tambah'])->name('keranjang.tambah');
        Route::get('/keranjang/kurang/{id}',[KeranjangController::class,'kurang'])->name('keranjang.kurang');
        Route::get('/keranjang/hapus/{id}',[KeranjangController::class,'hapus'])->name('keranjang.hapus');

        /* CHECKOUT */
        Route::post('/checkout',[CheckoutController::class,'process'])->name('checkout.process');
        Route::get('/checkout',[CheckoutController::class,'index'])->name('checkout');
        Route::post('/checkout/final',[CheckoutController::class,'finalCheckout'])->name('checkout.final');

        /* PROFILE */
        Route::get('/profil',[ProfileController::class,'index'])->name('user.profile');
        Route::get('/profil/edit',[ProfileController::class,'edit'])->name('user.profile.edit');
        Route::post('/profil/update',[ProfileController::class,'update'])->name('user.profile.update');
        Route::get('/profil/password',[ProfileController::class,'password'])->name('user.password');
        Route::post('/profil/password/update',[ProfileController::class,'passwordUpdate'])->name('user.password.update');

        /* PEMBAYARAN */
        Route::get('/pembayaran/{id}',[PembayaranController::class,'index'])->name('pembayaran');
        Route::post('/pembayaran/upload',[PembayaranController::class,'upload'])->name('pembayaran.upload');
        

        /* RIWAYAT */
        Route::get('/riwayat',[RiwayatController::class,'index'])->name('user.riwayat');
        Route::get('/riwayat/{id}',[RiwayatController::class,'detail'])->name('user.detail.pesanan');
        Route::get('/batal/pesanan/{id}',[RiwayatController::class,'batal'])->name('user.batal.pesanan');

        Route::view('/tentang-kami','user.tentang_kami');
        Route::view('/metode-pembayaran','user.metode_pembayaran');
        Route::view('/cara-belanja','user.cara_belanja');
        Route::view('/pengiriman','user.pengiriman');
        Route::view('/syarat_ketentuan','user.syarat_ketentuan');
    });

});