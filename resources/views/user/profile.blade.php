<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Profil Akun - KioStore</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
background:#e6edf5;
}

/* HEADER */

header{
background:#8FAFD6;
padding:15px 60px;
display:flex;
align-items:center;
justify-content:space-between;
}

.logo-area{
display:flex;
align-items:center;
gap:10px;
}

.logo-area img{
width:45px;
}

.logo-text{
font-size:22px;
font-weight:700;
color:#2A5CAA;
}

.header-icons{
display:flex;
gap:20px;
font-size:22px;
position:relative;
}

/* CONTAINER */

.container{
width:1100px;
margin:auto;
margin-top:40px;
}

.back-btn{
background:#e0e0e0;
padding:10px 20px;
border-radius:10px;
text-decoration:none;
color:black;
display:inline-block;
margin-bottom:20px;
}

.title{
font-size:32px;
font-weight:700;
margin-bottom:20px;
}

.card{
background:white;
border-radius:12px;
box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

/* PROFILE */

.profile-top{
display:flex;
}

.profile-left{
width:250px;
padding:30px;
border-right:1px solid #ddd;
text-align:center;
}

.avatar{
width:120px;
height:120px;
border-radius:50%;
background:#d6e1f0;
display:flex;
align-items:center;
justify-content:center;
font-size:45px;
font-weight:700;
margin:auto;
margin-bottom:20px;
}

.password-btn{
background:#e6edf5;
border:none;
padding:10px 20px;
border-radius:8px;
cursor:pointer;
}

.profile-right{
flex:1;
padding:30px;
}

.top-info{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:20px;
}

.buttons{
display:flex;
gap:10px;
}

.edit-btn{
background:black;
color:white;
padding:8px 20px;
border:none;
border-radius:8px;
cursor:pointer;
}

.logout-btn{
background:#c8d6ea;
padding:8px 20px;
border:none;
border-radius:8px;
cursor:pointer;
}

.info p{
margin:8px 0;
}

/* RIWAYAT */

.order-link{
text-decoration:none;
color:black;
}

.order-box{
margin-top:20px;
padding:18px;
display:flex;
justify-content:space-between;
align-items:center;
cursor:pointer;
}

.order-box:hover{
background:#f4f4f4;
}

/* CART BADGE */

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

/* FOOTER */

footer{
background:#8FAFD6;
padding:50px 60px 30px;
margin-top:80px;
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

.footer-grid a:hover{
text-decoration:underline;
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

<a href="{{ route('keranjang') }}">
🛒
@if(($totalCart ?? 0) > 0)
<span class="cart-badge">{{ $totalCart }}</span>
@endif
</a>

<a href="{{ route('user.profile') }}">
👤
</a>

</div>

</header>

<div class="container">

<a href="{{ route('user.dashboard') }}" class="back-btn">⬅ Kembali</a>

<div class="title">Profil Akun</div>

<div class="card">

<div class="profile-top">

<div class="profile-left">

<div class="avatar">
{{ strtoupper(substr($user->name,0,1)) }}
</div>

<a href="{{ route('user.password') }}">
<button class="password-btn">Ubah Password</button>
</a>

</div>

<div class="profile-right">

<div class="top-info">

<h2>Hai, {{ $user->name }} 👋</h2>

<div class="buttons">

<a href="{{ route('user.profile.edit') }}">
<button class="edit-btn">Edit</button>
</a>

<form action="{{ route('logout') }}" method="POST">
@csrf
<button class="logout-btn">Logout</button>
</form>

</div>

</div>

<div class="info">

<p><b>Nama :</b> {{ $user->name }}</p>
<p><b>Email :</b> {{ $user->email }}</p>
<p><b>Alamat :</b> {{ $user->alamat }}</p>

</div>

</div>

</div>

<hr>

<a href="{{ route('user.riwayat') }}" class="order-link">
<div class="order-box">
<div>📦 Riwayat Pesanan</div>
<div>></div>
</div>
</a>

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
<p><a href="{{ route('user.produk') }}">Produk</a></p>
<p><a href="{{ route('keranjang') }}">Keranjang</a></p>
</div>

<div>
<div class="footer-title">Bantuan</div>
<p><a href="/user/cara-belanja">Cara Belanja</a></p>
<p><a href="/user/metode-pembayaran">Metode Pembayaran</a></p>
<p><a href="/user/pengiriman">Pengiriman</a></p>
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