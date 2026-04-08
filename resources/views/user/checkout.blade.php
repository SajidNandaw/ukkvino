<!DOCTYPE html>
<html>
<head>

<title>Checkout - KioStore</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>

/* (CSS kamu tidak berubah, aku ringkas biar fokus ke logic) */

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
background:#dfe7f2;
}

header{
background:#8FAFD6;
padding:15px 60px;
display:flex;
justify-content:space-between;
align-items:center;
}

.logo{
display:flex;
align-items:center;
gap:10px;
}

.logo img{
width:45px;
}

.container{
padding:40px 80px;
}

.back-btn{
display:inline-block;
background:#eee;
padding:10px 20px;
border-radius:8px;
text-decoration:none;
margin-bottom:20px;
color:black;
}

.checkout-grid{
display:grid;
grid-template-columns:2fr 1fr;
gap:30px;
}

.checkout-box{
background:white;
padding:30px;
border-radius:12px;
}

.input{
width:100%;
padding:12px;
border:1px solid #ccc;
border-radius:8px;
margin-bottom:15px;
}

.payment-options{
display:flex;
gap:20px;
margin-top:15px;
}

.payment{
flex:1;
border:1px solid #ddd;
padding:12px;
border-radius:10px;
cursor:pointer;
}

.checkout-btn{
margin-top:25px;
background:black;
color:white;
padding:12px 25px;
border:none;
border-radius:10px;
font-size:16px;
cursor:pointer;
}

.summary{
background:white;
padding:20px;
border-radius:12px;
}

.item{
display:flex;
align-items:center;
gap:15px;
border-bottom:1px solid #eee;
padding:12px 0;
}

.item img{
width:60px;
background:#f4f4f4;
padding:8px;
border-radius:8px;
}

.item-name{
flex:1;
}

.total{
margin-top:20px;
font-size:18px;
font-weight:600;
}

/* MODAL */

.modal{
display:none;
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.5);
justify-content:center;
align-items:center;
z-index:999;
}

.modal-content{
background:white;
padding:30px;
border-radius:15px;
text-align:center;
width:350px;
}

</style>

</head>

<body>

<header>
<div class="logo">
<img src="{{ asset('uploads/assets/blue 2.png') }}">
<b>KioStore</b>
</div>

<div>
<a href="{{ route('user.profile') }}">👤</a>
</div>
</header>

<div class="container">

<a href="{{ route('keranjang') }}" class="back-btn">⬅ Ubah Keranjang</a>

<form id="checkoutForm" method="POST" action="{{ route('checkout.final') }}" onsubmit="return confirmCOD()">
@csrf

@php
    $jumlahProduk = count($keranjang);
    $ongkir = $jumlahProduk * 10000;
    $grandTotal = $total + $ongkir;
@endphp

<div class="checkout-grid">

<!-- LEFT -->
<div class="checkout-box">

<h1>CheckOut</h1>

<label>Nama Penerima</label>
<input type="text" name="nama" class="input" value="{{ $user->name }}" required>

<label>Alamat Lengkap</label>
<input type="text" name="alamat" class="input" value="{{ $user->alamat }}" required>

<h3>Metode Pembayaran</h3>

<div class="payment-options">

<label class="payment">
<input type="radio" name="metode" value="transfer" required>
Transfer (BANK)
</label>

<label class="payment">
<input type="radio" name="metode" value="cod">
COD
</label>

</div>

<!-- kirim ke backend -->
<input type="hidden" name="ongkir" value="{{ $ongkir }}">
<input type="hidden" name="grand_total" value="{{ $grandTotal }}">

<button type="submit" class="checkout-btn">
🛒 Buat Pesanan
</button>

</div>

<!-- RIGHT -->
<div class="summary">

<h2>Ringkasan Pesanan</h2>

@foreach($keranjang as $item)

<div class="item">

<img src="{{ asset('uploads/'.$item['gambar']) }}">

<div class="item-name">
<b>{{ $item['nama'] }}</b><br>
Rp {{ number_format($item['harga']) }}
</div>

<div>
Rp {{ number_format($item['subtotal']) }}
</div>

</div>

@endforeach

<div class="total">
Subtotal : Rp {{ number_format($total) }} <br>
Ongkir ({{ $jumlahProduk }} produk) : Rp {{ number_format($ongkir) }} <br>
<hr>
Total Bayar : Rp {{ number_format($grandTotal) }}
</div>

</div>

</div>

</form>

</div>

<!-- MODAL COD -->

<div id="codModal" class="modal">
<div class="modal-content">
<h2>Pesanan COD</h2>
<p>Barang akan segera dikirim 🚚<br>Silahkan siapkan pembayaran saat kurir datang.</p>
<button onclick="submitForm()">OK, Lanjutkan</button>
</div>
</div>

<script>

function confirmCOD(){
let metode = document.querySelector('input[name="metode"]:checked');

if(!metode){
alert("Silahkan pilih metode pembayaran");
return false;
}

if(metode.value === "cod"){
document.getElementById("codModal").style.display = "flex";
return false;
}

return true;
}

function submitForm(){
document.getElementById("checkoutForm").submit();
}

</script>

</body>
</html>