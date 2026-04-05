<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pengiriman Pesanan - KioStore</title>

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
box-shadow:0 3px 5px rgba(0,0,0,0.1);
}

.title{
font-size:30px;
font-weight:700;
margin-bottom:20px;
}

/* ================= BOX ================= */

.shipping-box{
background:white;
padding:35px;
border-radius:10px;
box-shadow:0 5px 20px rgba(0,0,0,0.08);
max-width:900px;
line-height:1.7;
}

.shipping-box p{
margin-bottom:12px;
color:#444;
}

.shipping-box ul{
margin-left:20px;
margin-bottom:15px;
}

.shipping-box ol{
margin-left:20px;
margin-bottom:15px;
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
Pengiriman Pesanan
</div>

<div class="shipping-box">

<p>
Pengiriman pesanan di KioStore dilakukan dengan cepat, aman, dan transparan.
Berikut informasi lengkap mengenai proses pengiriman barang hingga pesanan diterima.
</p>

<p><b>Alur Pengiriman :</b></p>

<ol>
<li>
<b>Pesanan Diproses</b><br>
Setelah pembayaran berhasil, pesanan akan diproses oleh penjual dan disiapkan untuk pengiriman.
</li>

<li>
<b>Pesanan Dikemas</b><br>
Produk dikemas dengan aman untuk menjaga kualitas barang selama proses pengiriman.
</li>

<li>
<b>Pesanan Dikirim</b><br>
Barang diserahkan ke jasa pengiriman. Nomor resi akan tersedia di halaman detail pesanan.
</li>

<li>
<b>Pesanan Diterima</b><br>
Pesanan sampai ke alamat tujuan sesuai dengan estimasi waktu pengiriman.
</li>
</ol>

<p><b>Jasa Pengiriman</b></p>

<p>
KioStore bekerja sama dengan berbagai jasa pengiriman terpercaya, antara lain:
</p>

<ul>
<li>JNE</li>
<li>J&T Express</li>
<li>SiCepat</li>
<li>AnterAja</li>
</ul>

<p>
Jasa pengiriman yang tersedia dapat berbeda tergantung lokasi pengiriman.
</p>

<p><b>Estimasi Waktu Pengiriman</b></p>

<ul>
<li>Dalam kota: 1 – 2 hari kerja</li>
<li>Luar kota: 2 – 5 hari kerja</li>
<li>Daerah terpencil: Menyesuaikan dengan kebijakan jasa pengiriman</li>
</ul>

<p>
Estimasi waktu dapat berubah tergantung kondisi cuaca dan operasional ekspedisi.
</p>

<p><b>Biaya Pengiriman</b></p>

<p>
Biaya pengiriman dihitung secara otomatis saat proses checkout berdasarkan:
</p>

<ul>
<li>Berat produk</li>
<li>Alamat tujuan</li>
<li>Jasa pengiriman yang dipilih</li>
</ul>

</div>

</div>


<footer>
© KioStore 2026. All Rights Reserved .
</footer>

</body>
</html>