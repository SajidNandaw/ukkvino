<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Ubah Password - KioStore</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
html{scroll-behavior:smooth;}
body{background:#e6edf5;}

a{text-decoration:none;color:inherit;}

/* HEADER */
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
.cart-icon{position:relative;text-decoration:none;color:black;}
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

/* CONTAINER */
.container{
width:500px;
margin:auto;
margin-top:80px;
}

/* CARD */
.card{
background:white;
padding:35px;
border-radius:12px;
box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

.title{
font-size:24px;
font-weight:600;
margin-bottom:20px;
}

label{
font-size:14px;
font-weight:500;
}

input{
width:100%;
padding:12px;
margin-top:6px;
margin-bottom:15px;
border:1px solid #ccc;
border-radius:8px;
}

button{
width:100%;
padding:12px;
background:black;
color:white;
border:none;
border-radius:8px;
cursor:pointer;
font-weight:500;
}

button:hover{opacity:0.9;}

.back{
display:inline-block;
margin-bottom:20px;
text-decoration:none;
color:black;
background:#ddd;
padding:8px 15px;
border-radius:8px;
}

/* FOOTER */
footer{
background:#8FAFD6;
padding:50px 60px 30px;
}

.footer-grid{
display:grid;
grid-template-columns:repeat(4,1fr);
gap:40px;
}

.footer-title{
font-weight:700;
margin-bottom:12px;
}

.footer-grid p,
.footer-grid a{
font-size:14px;
margin-bottom:6px;
color:black;
text-decoration:none;
}

.footer-bottom{
background:#4E8EDB;
color:white;
text-align:center;
padding:18px;
font-size:14px;
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
<a href="{{ route('keranjang') }}" class="cart-icon">
🛒
@if($totalCart > 0)
<span class="cart-badge">{{ $totalCart }}</span>
@endif
</a>

<a href="{{ route('user.profile') }}" class="cart-icon">👤</a>
</div>
</header>

<div class="container">

<a href="{{ route('user.profile') }}" class="back">⬅ Kembali</a>

<div class="card">

<div class="title">Ubah Password</div>

@if(session('error'))
<p style="color:red">{{ session('error') }}</p>
@endif

@if(session('success'))
<p style="color:green">{{ session('success') }}</p>
@endif

@if ($errors->any())
<div style="color:red">
@foreach ($errors->all() as $error)
<p>{{ $error }}</p>
@endforeach
</div>
@endif

<form action="{{ route('user.password.update') }}" method="POST">
@csrf

<label>Password Lama</label>
<input type="password" name="password_lama" required>

<label>Password Baru</label>
<input type="password" name="password_baru" required>

<label>Konfirmasi Password</label>
<input type="password" name="konfirmasi_password" required>

<button type="submit">Ubah Password</button>
</form>

</div>
</div>

<!-- FOOTER -->
<footer>
<div class="footer-grid">

<div>
<div class="footer-title">KioStore</div>
<p>KioStore adalah e-commerce fashion lokal terpercaya.</p>
</div>

<div>
<div class="footer-title">Layanan</div>
<p><a href="/user/tentang-kami">Tentang Kami</a></p>
<p><a href="{{ route('user.dashboard') }}">Produk</a></p>
<p><a href="{{ route('keranjang') }}">Keranjang</a></p>
</div>

<div>
<div class="footer-title">Bantuan</div>
<p><a href="/user/cara-belanja">Cara Belanja</a></p>
<p><a href="/user/metode_pembayaran">Metode Pembayaran</a></p>
<p><a href="/user/pengiriman">Pengiriman</a></p>
<p><a href="/user/syarat_ketentuan">Syarat & Ketentuan</a></p>
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