<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Metode Pembayaran - KioStore</title>

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

/* ================= BOX ================= */

.payment-box{
background:white;
padding:35px;
border-radius:10px;
box-shadow:0 5px 20px rgba(0,0,0,0.08);
max-width:850px;
}

.payment-box h1{
font-size:32px;
margin-bottom:20px;
}

.payment-box p{
margin-bottom:15px;
line-height:1.7;
color:#444;
}

.payment-box ol{
margin-left:20px;
line-height:1.8;
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

<div class="payment-box">

<h1>Metode Pembayaran</h1>

<p>
Kioters, demi kemudahan kamu bertransaksi di KioStore, kami telah menyediakan berbagai
pilihan metode pembayaran Transaksi Digital.
</p>

<p>
Jika kamu sudah melakukan pembayaran, mohon kesediannya untuk menunggu proses
verifikasi maksimal 1x24 jam.
Catatan: Apabila kamu ingin mengubah metode bayar, silakan checkout ulang dan
memilih metode pembayaran yang diinginkan.
</p>

<p>
Kioters, KioStore menyediakan dua pilihan metode pembayaran yang dapat kamu gunakan,
di antaranya:
</p>

<ol>
<li>Transfer (Bank)</li>
<li>COD (Cash On Delivery)</li>
</ol>

</div>

</div>


<footer>
© KioStore 2026. All Rights Reserved .
</footer>

</body>
</html>