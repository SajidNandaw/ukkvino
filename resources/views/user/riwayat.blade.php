<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Riwayat Pesanan - KioStore</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
body{background:#e7eef6;}

header{background:#8FAFD6;padding:15px 60px;display:flex;justify-content:space-between;align-items:center;}
.logo{display:flex;align-items:center;gap:10px;}
.logo img{width:45px;}
.icons{font-size:22px;display:flex;gap:15px;}

.container{padding:40px 80px;}

.back-btn{
background:#eee;
padding:10px 20px;
border-radius:8px;
text-decoration:none;
color:black;
display:inline-block;
margin-bottom:20px;
}

.title{font-size:26px;margin-bottom:15px;}

.filter-wrapper{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:20px;
}

.filter-group{
display:flex;
background:#ddd;
border-radius:10px;
overflow:hidden;
}

.filter-btn{
padding:8px 18px;
cursor:pointer;
font-size:13px;
border:none;
background:transparent;
transition:0.2s;
}

.filter-btn:hover{background:#bbb;}

.filter-btn.active{
background:black;
color:white;
}

.sort-box select{
padding:6px 10px;
border-radius:6px;
border:1px solid #ccc;
}

.order-card{
background:white;
border-radius:10px;
padding:15px;
margin-bottom:20px;
display:flex;
justify-content:space-between;
box-shadow:0 2px 5px rgba(0,0,0,0.1);
}

.order-left{
display:flex;
gap:15px;
align-items:center;
}

.order-left img{
width:70px;
background:#f3f3f3;
padding:10px;
border-radius:8px;
}

.order-info{font-size:14px;}
.order-total{margin-left:30px;font-weight:500;}

.status{
padding:6px 12px;
border-radius:6px;
font-size:13px;
font-weight:500;
}

.pending{background:#ffe97a;}
.dibayar{background:#b9f3c7;}
.dikirim{background:#9db8ff;}
.selesai{background:#b9f3c7;}
.dibatalkan{background:#ff8a8a;}

.metode{
font-size:12px;
padding:4px 10px;
border-radius:6px;
background:#eee;
}

.cod{background:#ffd6d6;}
.transfer{background:#d6e4ff;}

.detail-btn{
padding:6px 14px;
border-radius:6px;
background:#eee;
text-decoration:none;
color:black;
font-size:13px;
}

.cancel-btn{
padding:6px 14px;
border-radius:6px;
background:#ff8a8a;
text-decoration:none;
color:white;
font-size:13px;
margin-left:5px;
}

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
<div class="logo">
<img src="{{ asset('uploads/assets/blue 2.png') }}">
<b>KioStore</b>
</div>

<div class="icons">
<a href="{{ route('keranjang') }}">🛒</a>
<a href="{{ route('user.profile') }}">👤</a>
</div>
</header>

<div class="container">

<a href="{{ route('user.profile') }}" class="back-btn">⬅ Kembali</a>

<div class="title">Riwayat Pesanan</div>

<div class="filter-wrapper">

<div class="filter-group">
<button class="filter-btn active" onclick="filterStatus('all', this)">Semua</button>
<button class="filter-btn" onclick="filterStatus('dibayar', this)">Diproses</button>
<button class="filter-btn" onclick="filterStatus('dikirim', this)">Dikirim</button>
<button class="filter-btn" onclick="filterStatus('selesai', this)">Selesai</button>
<button class="filter-btn" onclick="filterStatus('dibatalkan', this)">Dibatalkan</button>
</div>

<div class="sort-box">
<select onchange="sortData(this.value)">
<option value="desc">Terbaru</option>
<option value="asc">Terlama</option>
</select>
</div>

</div>

@if($riwayat->count() == 0)
<p>Belum ada pesanan.</p>
@endif

<div id="list">

@foreach($riwayat as $row)

@php
$status = strtolower(trim($row->status));

// mapping semua kemungkinan
if($status == 'menunggu') $status = 'pending';
if($status == 'proses') $status = 'dibayar';
if($status == 'kirim') $status = 'dikirim';
if($status == 'batal') $status = 'dibatalkan';

// 🔥 kalau tidak dikenal → jadi diproses
$allowed = ['pending','dibayar','dikirim','selesai','dibatalkan'];
if(!in_array($status, $allowed)){
    $status = 'dibayar';
}
@endphp

<div class="order-card" data-status="{{ $status }}" data-date="{{ $row->tanggal }}">

<div class="order-left">

<img src="{{ asset('uploads/'.($row->gambar ?? 'default.png')) }}">

<div class="order-info">
<b>#{{ $row->id }}</b><br>
{{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d F Y') }}<br>
{{ $row->nama }} x {{ $row->qty }}

<br><br>

@if($row->metode == "cod")
<span class="metode cod">COD</span>
@else
<span class="metode transfer">Transfer Bank</span>
@endif
</div>

<div class="order-total">
Total Rp {{ number_format($row->total) }}
</div>

</div>

<div>

@if($status == "pending")
<span class="status pending">Menunggu</span>

@elseif($status == "dibayar")
<span class="status dibayar">Diproses</span>

@elseif($status == "dikirim")
<span class="status dikirim">Dikirim</span>

@elseif($status == "selesai")
<span class="status selesai">Selesai</span>

@elseif($status == "dibatalkan")
<span class="status dibatalkan">Dibatalkan</span>
@endif

<br><br>

<a href="{{ route('user.detail.pesanan', $row->id) }}" class="detail-btn">
Detail >
</a>

@if(in_array($status, ['pending','dibayar']))
<a href="{{ route('user.batal.pesanan', $row->id) }}"
   class="cancel-btn"
   onclick="return confirm('Yakin batalkan pesanan?')">
   Batalkan
</a>
@endif

</div>

</div>

@endforeach

</div>

</div>

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
<p><a href="/user/metode-pembayaran">Metode Pembayaran</a></p>
<p><a href="/user/pengiriman">Pengiriman</a></p>
<p><a href="/user/syarat-ketentuan">Syarat & Ketentuan</a></p>
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

<script>
function filterStatus(status, el){
    document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
    el.classList.add('active');

    document.querySelectorAll('.order-card').forEach(card => {
        if(status === 'all'){
            card.style.display = 'flex';
        }else{
            card.style.display = (card.dataset.status === status) ? 'flex' : 'none';
        }
    });
}

function sortData(type){
    let list = document.getElementById('list');
    let items = Array.from(list.children);

    items.sort((a,b)=>{
        let dateA = new Date(a.dataset.date);
        let dateB = new Date(b.dataset.date);
        return type === 'asc' ? dateA - dateB : dateB - dateA;
    });

    items.forEach(el => list.appendChild(el));
}
</script>

</body>
</html>