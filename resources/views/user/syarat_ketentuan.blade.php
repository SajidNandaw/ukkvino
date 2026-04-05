<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Syarat & Ketentuan - KioStore</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
background:#e7edf5;
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
box-shadow:0 3px 5px rgba(0,0,0,0.1);
}

.title{
font-size:34px;
font-weight:800;
text-align:center;
margin-bottom:30px;
}

/* ================= BOX ================= */

.policy-box{
background:white;
padding:35px;
border-radius:10px;
box-shadow:0 5px 20px rgba(0,0,0,0.08);
max-width:900px;
margin:auto;
line-height:1.7;
color:#444;
}

.policy-box ul{
margin-left:20px;
margin-top:10px;
}

/* ================= FOOTER ================= */

footer{
background:#4E8EDB;
color:white;
text-align:center;
padding:18px;
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

<a href="{{ url('/user/keranjang') }}" class="cart-icon">
🛒
@if($totalCart > 0)
<span class="cart-badge">{{ $totalCart }}</span>
@endif
</a>

<a href="{{ url('/user/profil') }}" class="cart-icon">
👤
</a>

</div>

</header>


<div class="container">

<a href="{{ url('/user/dashboard') }}" class="back-btn">← Beranda</a>

<div class="title">
Syarat, Ketentuan & Kebijakan Privasi
</div>

<div class="policy-box">

<p><b>Syarat, Ketentuan & Kebijakan Privasi</b></p>

<p>KioStore</p>

<p>
Dengan menggunakan layanan KioStore, pengguna dianggap telah membaca,
memahami, dan menyetujui syarat, ketentuan, serta kebijakan privasi berikut.
</p>

<p><b>1. Penggunaan Layanan</b><br>
KioStore adalah platform e-commerce yang menyediakan layanan jual beli produk.
Pengguna wajib menggunakan layanan ini secara wajar dan tidak melanggar hukum yang berlaku.
</p>

<p><b>2. Akun Pengguna</b><br>
Pengguna bertanggung jawab atas keamanan akun dan data login masing-masing.
Segala aktivitas yang terjadi melalui akun pengguna menjadi tanggung jawab pemilik akun.
</p>

<p><b>3. Data yang Dikumpulkan</b></p>

<ul>
<li>Nama</li>
<li>Email</li>
<li>Nomor ponsel</li>
<li>Alamat pengiriman</li>
</ul>

<p>
Data ini digunakan untuk keperluan transaksi, pengiriman, dan peningkatan layanan.
</p>

<p><b>4. Keamanan & Privasi Data</b><br>
KioStore berkomitmen menjaga kerahasiaan data pengguna dan tidak membagikan data pribadi kepada pihak ketiga tanpa izin pengguna, kecuali diwajibkan oleh hukum.
</p>

<p><b>5. Transaksi & Pesanan</b><br>
Semua transaksi yang dilakukan melalui KioStore mengikuti alur pemesanan yang tersedia.
</p>

<p><b>6. Perubahan Layanan</b><br>
KioStore berhak melakukan perubahan pada layanan, fitur, maupun kebijakan untuk meningkatkan kualitas platform.
</p>

<p><b>7. Persetujuan</b><br>
Dengan mendaftar dan menggunakan KioStore, pengguna menyetujui seluruh syarat, ketentuan, dan kebijakan privasi yang berlaku.
</p>

</div>

</div>


<footer>
© KioStore 2026. All Rights Reserved .
</footer>

</body>
</html>