<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Detail Produk</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
body{background:#e6edf5;}

header{
background:#8FAFD6;
padding:15px 60px;
display:flex;
align-items:center;
justify-content:space-between;
}

.logo-area{display:flex;align-items:center;gap:10px;}
.logo-area img{width:45px;}
.logo-text{font-size:22px;font-weight:700;color:#2A5CAA;}

.header-icons{display:flex;align-items:center;gap:25px;font-size:22px;}

.cart-icon{
position:relative;
text-decoration:none;
color:black;
}

.cart-badge{
position:absolute;
top:-8px;
right:-12px;
background:red;
color:white;
font-size:11px;
padding:2px 6px;
border-radius:50%;
}

.container{padding:40px 80px;}

.back-btn{
display:inline-block;
padding:10px 25px;
background:#e0e0e0;
border-radius:10px;
text-decoration:none;
color:black;
margin-bottom:30px;
}

.detail{display:flex;gap:60px;}

.image-box{
background:#d9d9d9;
padding:40px;
border-radius:10px;
}

.image-box img{width:350px;}

.detail-info h1{
font-size:40px;
margin-bottom:10px;
}

.rating{
color:gold;
font-size:22px;
margin-bottom:10px;
}

.desc-title{
font-size:24px;
font-weight:600;
margin-top:20px;
}

.desc{
margin-top:10px;
line-height:1.6;
}

.price-box{
display:flex;
gap:20px;
align-items:center;
margin-top:25px;
}

.price-tag{
background:#e0e0e0;
padding:12px 25px;
border-radius:10px;
}

.cart-btn{
display:inline-block;
text-decoration:none; /* hapus underline */
text-align:center;
background:#b6e2a1;
padding:12px 30px;
border-radius:10px;
border:none;
color:black;
cursor:pointer;
font-weight:600;
transition:0.3s;
}

.cart-btn:hover{
background:#a1d58e;
}

.shipping{
margin-top:40px;
background:#e0e0e0;
padding:25px;
border-radius:10px;
width:350px;
}
</style>
</head>

<body>

<header>

<div class="logo-area">
<img src="{{ asset('uploads/assets/blue 2.png') }}">
<div class="logo-text">KioStore</div>
</div>

<div class="header-icons">
<!-- Semua diarahkan ke login jika belum login -->
<a href="{{ route('login') }}" class="cart-icon">
🛒
</a>

<a href="{{ route('login') }}" class="cart-icon">
👤
</a>

</div>

</header>

<div class="container">

<!-- Kembali ke katalog -->
<a href="{{ route('public.katalog') }}" class="back-btn">⬅ Kembali ke Beranda Produk</a>

<div class="detail">

<div>

<div class="image-box">
<img src="{{ asset('uploads/'.$produk->gambar) }}">
</div>

<div class="shipping">
<h3>Informasi Pengiriman</h3>
<p>Subtotal : Rp {{ number_format($produk->harga) }}</p>
<p>Ongkos Kirim : Rp 20.000</p>
<p><strong>Total : Rp {{ number_format($produk->harga + 20000) }}</strong></p>
</div>

</div>

<div class="detail-info">

<h1>{{ $produk->nama }}</h1>

<!-- 🔥 RATING REALTIME -->
<div class="rating">
@php
    $rating = round($avgRating);
@endphp

@for($i = 1; $i <= 5; $i++)
    @if($i <= $rating)
        ★
    @else
        ☆
    @endif
@endfor

({{ $countUlasan }} ulasan)
</div>

<p>{{ $produk->deskripsi }}</p>

<div class="desc-title">Deskripsi Produk</div>

<div class="desc">
{!! nl2br(e($produk->deskripsi)) !!}
</div>

<div class="price-box">

<div class="price-tag">
Harga : Rp {{ number_format($produk->harga) }}
</div>

<!-- Tombol keranjang diarahkan ke login -->
<a href="{{ route('login') }}" class="cart-btn">
🛒 Masukkan ke Keranjang
</a>

</div>

</div>

</div>

</div>

</body>
</html>