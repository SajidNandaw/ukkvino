<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Keranjang Belanja - KioStore</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
body{background:#c9d3df;}

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
color:#2A5CAA;
}

.logo img{width:45px;}

.container{padding:40px 80px;}
h1{margin-bottom:20px;}

.back-btn{
display:inline-block;
margin-bottom:25px;
padding:8px 20px;
background:#e0e0e0;
border-radius:8px;
text-decoration:none;
color:black;
}

.cart-box{
background:#ddd;
border-radius:15px;
padding:20px;
}

.cart-header,.cart-item{
display:grid;
grid-template-columns:0.5fr 2fr 1fr 1fr 1fr 1fr;
align-items:center;
padding:15px;
}

.cart-header{
font-weight:600;
border-bottom:1px solid #aaa;
}

.cart-item{
border-bottom:1px solid #bbb;
}

.product-info{
display:flex;
align-items:center;
gap:15px;
}

.product-info img{
width:80px;
height:80px;
object-fit:contain;
background:#fff;
padding:10px;
border-radius:8px;
}

.qty-box{
display:flex;
align-items:center;
gap:10px;
}

.qty-btn{
background:#eee;
padding:5px 10px;
border-radius:5px;
text-decoration:none;
color:black;
}

.delete-btn{
color:red;
text-decoration:none;
}

.total-section{
margin-top:30px;
text-align:right;
}

.checkout-btn{
margin-top:15px;
background:black;
color:white;
padding:12px 40px;
border-radius:10px;
border:none;
cursor:pointer;
}

.empty{
text-align:center;
padding:40px;
}
</style>

</head>

<body>

<header>
<div class="logo">
<img src="{{ asset('uploads/assets/blue 2.png') }}">
<strong>KioStore</strong>
</div>
</header>

<div class="container">

<a href="{{ route('user.dashboard') }}" class="back-btn">⬅ Kembali ke Dashboard</a>

<h1>Keranjang Belanja</h1>

{{-- ALERT ERROR --}}
@if(session('error'))
<div style="color:red; margin-bottom:10px;">
    {{ session('error') }}
</div>
@endif

<form action="{{ route('checkout.process') }}" method="POST">
@csrf

<div class="cart-box">

<div class="cart-header">
<div>Pilih</div>
<div>Produk</div>
<div>Harga</div>
<div>Jumlah</div>
<div>Subtotal</div>
<div>Aksi</div>
</div>

@if($keranjang->count() > 0)

@foreach($keranjang as $item)

@php
$subtotal = $item->harga * $item->jumlah;
@endphp

<div class="cart-item">

<!-- CHECKBOX -->
<div>
<input type="checkbox" name="pilih[]" value="{{ $item->keranjang_id }}">
</div>

<!-- PRODUK -->
<div class="product-info">
<img src="{{ asset('uploads/'.$item->gambar) }}">
{{ $item->nama }}
</div>

<!-- HARGA -->
<div>
Rp {{ number_format($item->harga) }}
</div>

<!-- JUMLAH -->
<div class="qty-box">
<a class="qty-btn" href="{{ route('keranjang.kurang',$item->keranjang_id) }}">-</a>

{{ $item->jumlah }}

<a class="qty-btn" href="{{ route('keranjang.tambah',$item->keranjang_id) }}">+</a>
</div>

<!-- SUBTOTAL -->
<div>
Rp {{ number_format($subtotal) }}
</div>

<!-- HAPUS -->
<div>
<a class="delete-btn"
href="{{ route('keranjang.hapus',$item->keranjang_id) }}"
onclick="return confirm('Yakin ingin menghapus produk ini?')">
Hapus
</a>
</div>

</div>

@endforeach

@else

<div class="empty">
Keranjang masih kosong 🛒
</div>

@endif

</div>

@if($keranjang->count() > 0)

<div class="total-section">

<h2>Total Belanja: Rp {{ number_format($totalBelanja) }}</h2>

<button type="submit" class="checkout-btn">
Checkout
</button>

</div>

@endif

</form>

</div>

</body>
</html>