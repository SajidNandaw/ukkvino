<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Cara Belanja - KioStore</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
/* (CSS SAMA PERSIS, gak perlu diubah) */
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
body{background:#e6edf5;display:flex;flex-direction:column;min-height:100vh;}
header{background:#8FAFD6;padding:15px 60px;display:flex;align-items:center;justify-content:space-between;}
.logo-area{display:flex;align-items:center;gap:10px;}
.logo-area img{width:45px;}
.logo-text{font-size:22px;font-weight:700;color:#2A5CAA;}
.search-box{width:500px;background:#4E8EDB;border-radius:50px;padding:10px 25px;}
.search-box input{width:100%;border:none;outline:none;background:transparent;color:white;}
.search-box input::placeholder{color:#e0e0e0;}
.header-icons{display:flex;align-items:center;gap:25px;font-size:22px;}
.cart-icon{position:relative;text-decoration:none;color:black;}
.cart-badge{position:absolute;top:-8px;right:-12px;background:red;color:white;font-size:11px;padding:2px 6px;border-radius:50%;}
.container{padding:40px 80px;flex:1;}
.back-btn{display:inline-block;background:#e0e0e0;padding:10px 20px;border-radius:10px;text-decoration:none;color:black;margin-bottom:25px;}
.title{font-size:32px;font-weight:700;margin-bottom:5px;}
.subtitle{color:#555;margin-bottom:30px;}
.steps{background:white;border-radius:10px;overflow:hidden;border:1px solid #ddd;}
.step{display:flex;gap:20px;padding:25px;border-bottom:1px solid #eee;}
.number{background:#4E8EDB;color:white;width:35px;height:35px;border-radius:50%;display:flex;align-items:center;justify-content:center;}
footer{background:#4E8EDB;color:white;text-align:center;padding:18px;margin-top:auto;}
</style>
</head>

<body>

<header>

<div class="logo-area">
<img src="{{ asset('uploads/assets/blue 2.png') }}">
<div class="logo-text">KioStore</div>
</div>

<div class="search-box">
<input type="text" placeholder="Cari Di KioStore">
</div>

<div class="header-icons">

<a href="{{ route('keranjang') }}" class="cart-icon">
🛒
@if($totalCart > 0)
<span class="cart-badge">{{ $totalCart }}</span>
@endif
</a>

<a href="{{ route('user.profile') }}" class="cart-icon">
👤
</a>

</div>

</header>

<div class="container">

<a href="{{ route('user.dashboard') }}" class="back-btn">← Beranda</a>

<div class="title">Cara Belanja</div>

<div class="subtitle">
Ikuti cara cara berikut untuk berbelanja di KioStore dengan mudah
</div>

<div class="steps">

<div class="step">
<div class="number">1</div>
<div>
<h3>Cari Produk</h3>
<p>Gunakan kolom pencarian untuk menemukan barang.</p>
</div>
</div>

<div class="step">
<div class="number">2</div>
<div>
<h3>Tambahkan Ke Keranjang</h3>
<p>Klik tombol “Masukkan Ke Keranjang”.</p>
</div>
</div>

<div class="step">
<div class="number">3</div>
<div>
<h3>Checkout Pesanan</h3>
<p>Buka keranjang lalu klik checkout.</p>
</div>
</div>

<div class="step">
<div class="number">4</div>
<div>
<h3>Lakukan Pembayaran</h3>
<p>Pilih metode pembayaran dan selesaikan.</p>
</div>
</div>

</div>

</div>@if(!isset($totalCart))
    @php $totalCart = 0; @endphp
@endif</div>

</div>

<footer>
© KioStore 2026. All Rights Reserved .
</footer>

</body>
</html>