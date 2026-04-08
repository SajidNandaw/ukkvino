<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>KioStore - Katalog</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
html{scroll-behavior:smooth;}
body{background:#e6edf5;}
a{text-decoration:none;color:inherit;}

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
.search-box{width:500px;background:#4E8EDB;border-radius:50px;padding:10px 25px;}
.search-box input{width:100%;border:none;outline:none;background:transparent;color:white;font-size:14px;}
.search-box input::placeholder{color:#e0e0e0;}
.header-icons{display:flex;align-items:center;gap:15px;font-size:16px;}
.header-icons a{background:white;color:#2A5CAA;padding:8px 15px;border-radius:8px;font-weight:600;}
.header-icons a:hover{background:#4E8EDB;color:white;}

/* HERO */
.hero{
margin:40px 60px;
background:#9DB8DA;
border-radius:20px;
padding:50px;
display:flex;
justify-content:space-between;
align-items:center;
box-shadow:0 10px 25px rgba(0,0,0,0.1);
}
.hero-text h1{font-size:28px;font-weight:800;line-height:1.5;}
.hero-text span{font-size:48px;font-weight:800;color:white;}
.shop-btn{display:inline-block;margin-top:20px;background:black;color:white;padding:12px 30px;border-radius:10px;text-decoration:none;font-weight:500;}
.hero img{width:350px;}

/* PRODUK */
.products{
padding:10px 60px 60px;
display:grid;
grid-template-columns:repeat(3,1fr);
gap:35px;
}
.card-link{display:block;text-decoration:none;color:inherit;}
.card{
background:white;
padding:25px;
border-radius:15px;
box-shadow:0 5px 20px rgba(0,0,0,0.08);
transition:0.3s;
}
.card:hover{transform:translateY(-7px);cursor:pointer;}
.product-img{
height:170px;
background:#f4f6f9;
border-radius:12px;
display:flex;
align-items:center;
justify-content:center;
margin-bottom:15px;
}
.product-img img{max-height:150px;}
.card h3{font-size:16px;font-weight:600;margin-bottom:5px;}
.desc{font-size:12px;color:#777;margin-bottom:8px;}
.price{font-weight:600;margin-bottom:5px;}
.sold{font-size:12px;color:#888;}

footer{
background:#8FAFD6;
padding:50px 60px 30px;
}
.footer-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:40px;}
.footer-title{font-weight:700;margin-bottom:12px;}
.footer-grid p,
.footer-grid a{font-size:14px;margin-bottom:6px;color:black;text-decoration:none;}
.footer-bottom{background:#4E8EDB;color:white;text-align:center;padding:18px;font-size:14px;}
</style>
</head>

<body>

<header>

<div class="logo-area">
<img src="{{ asset('uploads/assets/blue 2.png') }}">
<div class="logo-text">KioStore</div>
</div>

<form method="GET" class="search-box" action="{{ route('public.katalog') }}">
<input type="text" name="search" placeholder="Cari Di KioStore" value="{{ $keyword ?? '' }}">
</form>

<div class="header-icons">
<a href="{{ route('login') }}">Masuk</a>
<a href="{{ route('register') }}">Daftar</a>
</div>

</header>

<!-- HERO -->
<div class="hero">

<div class="hero-text">
<h1>
CARI FASHION TERKINI TAPI <br>
SUSAH CARINYA? <br>
CARI AJA DI
</h1>

<span>KioStore!</span><br>

<a href="#produk" class="shop-btn">Belanja Sekarang</a>

</div>

<img src="{{ asset('uploads/assets/banner.png') }}">

</div>

@if(!empty($keyword))
<h2 style="margin:20px 60px;">Hasil pencarian: "{{ $keyword }}"</h2>
@endif

<div class="products" id="produk">

@if($produk->count() > 0)

@foreach($produk as $row)

<!-- Klik produk langsung ke detail.blade.php -->
<a href="{{ route('produk.detail', $row->id) }}" class="card-link">

<div class="card">

<div class="product-img">
@if(!empty($row->gambar))
<img src="{{ asset('uploads/'.$row->gambar) }}">
@else
No Image
@endif
</div>

<h3>{{ $row->nama }}</h3>

<div class="desc">
{{ Str::limit($row->deskripsi,60) }}
</div>

<div class="price">
Rp {{ number_format($row->harga) }}
</div>

<div class="sold">
Stok: {{ $row->stok }}
</div>

</div>
</a>

@endforeach

@else

<p style="margin-left:60px;">Produk tidak ditemukan.</p>

@endif

</div>

<footer>

<div class="footer-grid">

<div>
<div class="footer-title">KioStore</div>
<p>KioStore adalah e-commerce fashion lokal terpercaya.</p>
</div>

<div>
<div class="footer-title">Layanan</div>
<p><a href="{{ route('login') }}">Masuk / Daftar</a></p>
<p><a href="{{ route('public.katalog') }}">Produk</a></p>
</div>

<div>
<div class="footer-title">Bantuan</div>
<p><a href="{{ route('login') }}">Cara Belanja</a></p>
<p><a href="{{ route('login') }}">Metode Pembayaran</a></p>
<p><a href="{{ route('login') }}">Pengiriman</a></p>
<p><a href="{{ route('login') }}">Syarat & Ketentuan</a></p>
</div> 

<div>
<div class="footer-title">Hubungi Kami</div>
<p>KioStore@gmail.com</p>
<p>0854-3211-67381</p>
<p>Jawa Barat, Indonesia</p>
</div>

</div>

</footer>

<div class="footer-bottom">
© KioStore 2026. All Rights Reserved.
</div>

</body>
</html>