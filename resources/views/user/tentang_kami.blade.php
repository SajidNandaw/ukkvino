<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tentang KioStore</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
background:#e6edf5;
display:flex;
flex-direction:column;
min-height:100vh;
}

/* ================= HEADER ================= */

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

.search-box{
width:500px;
background:#4E8EDB;
border-radius:50px;
padding:10px 25px;
}

.search-box input{
width:100%;
border:none;
outline:none;
background:transparent;
color:white;
}

.search-box input::placeholder{
color:#e0e0e0;
}

.header-icons{
display:flex;
align-items:center;
gap:25px;
font-size:22px;
}

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

/* ================= CONTENT ================= */

.container{
padding:40px 80px;
flex:1;
}

.back-btn{
display:inline-block;
background:#e0e0e0;
padding:10px 20px;
border-radius:10px;
text-decoration:none;
color:black;
margin-bottom:25px;
}

.title{
font-size:36px;
font-weight:700;
margin-bottom:20px;
}

.desc{
line-height:1.8;
color:#444;
margin-bottom:40px;
}

/* ================= BOX ================= */

.info-box{
display:grid;
grid-template-columns:1fr 1fr;
border-radius:12px;
overflow:hidden;
box-shadow:0 5px 20px rgba(0,0,0,0.08);
}

.box{
background:white;
padding:35px;
text-align:center;
border-right:1px solid #ddd;
}

.box:last-child{
border-right:none;
}

.box h2{
margin-bottom:15px;
font-size:22px;
}

.box p{
font-size:14px;
line-height:1.7;
color:#555;
}

/* ================= FOOTER ================= */

footer{
background:#8FAFD6;
text-align:center;
padding:20px;
font-size:14px;
margin-top:auto;
}

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

<div class="title">
KioStore adalah platform belanja online terdepan di Asia Tenggara
</div>

<div class="desc">

Diluncurkan pada tahun 2025, KioStore hadir sebagai platform belanja online
yang disesuaikan dengan kebutuhan tiap wilayah, menawarkan proses belanja
yang praktis, aman, dan cepat melalui sistem pembayaran serta dukungan
logistik yang andal.

KioStore meyakini bahwa pengalaman berbelanja online harus mudah diakses,
terjangkau, dan menyenangkan. Inilah visi yang terus kami wujudkan melalui
KioStore untuk para pengguna setiap hari.

</div>

<div class="info-box">

<div class="box">
<h2>Tujuan Kami</h2>
<p>
Kami percaya pada kekuatan transformatif dari teknologi dan ingin
mengubah dunia menjadi lebih baik dengan menyediakan platform untuk
menghubungkan pembeli dan penjual dalam satu komunitas.
</p>
</div>

<div class="box">
<h2>Posisi Kami</h2>
<p>
Untuk pengguna internet di seluruh wilayah, KioStore menawarkan
pengalaman belanja online komprehensif, dari berbagai pilihan produk
hingga layanan untuk memenuhi kebutuhan konsumen tanpa hambatan.
</p>
</div>

</div>

</div>

<footer>
© KioStore 2026. All Rights Reserved.
</footer>

</body>
</html>