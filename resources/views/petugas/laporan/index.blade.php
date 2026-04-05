<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan - KioStore</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Segoe UI',sans-serif;
}

body{
display:flex;
background:#f1f5f9;
}

/* SIDEBAR */

.sidebar{
width:220px;
background:#fff;
height:100vh;
padding:20px;
position:fixed;
border-right:1px solid #e5e7eb;
display:flex;
flex-direction:column;
}

.logo{
display:flex;
align-items:center;
gap:10px;
}

.logo img{
width:35px;
}

.logo-text h2{
color:#2563eb;
font-size:20px;
}

.logo-text span{
font-size:13px;
color:#6b7280;
}

.menu{
margin-top:30px;
flex:1;
}

.menu ul{
list-style:none;
}

.menu ul li{
margin-bottom:12px;
}

.menu ul li a{
text-decoration:none;
color:#374151;
padding:10px;
display:block;
border-radius:8px;
transition:0.2s;
}

.menu ul li a:hover,
.menu ul li a.active{
background:#e0e7ff;
color:#1d4ed8;
}

/* LOGOUT */

.logout{
background:black;
color:white;
padding:10px;
border-radius:8px;
border:none;
margin-top:auto;
cursor:pointer;
width:100%;
}

/* MAIN */

.main{
margin-left:220px;
padding:30px;
width:100%;
}

.topbar{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:30px;
}

.profile{
display:flex;
align-items:center;
gap:10px;
}

.profile-circle{
width:40px;
height:40px;
background:#6366f1;
border-radius:50%;
display:flex;
align-items:center;
justify-content:center;
color:white;
font-weight:bold;
}

/* CARD */

.card-wrapper{
display:flex;
justify-content:center;
}

.card{
background:white;
padding:18px;
border-radius:15px;
box-shadow:0 4px 15px rgba(0,0,0,0.05);
margin-bottom:25px;
width:100%;
max-width:650px;
}

.card-header{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:15px;
}

.btn-download{
padding:6px 12px;
background:#2563eb;
color:white;
border-radius:6px;
font-size:12px;
text-decoration:none;
}

table{
width:100%;
border-collapse:collapse;
}

th,td{
padding:10px;
text-align:left;
border-bottom:1px solid #eee;
font-size:13px;
}

th{
background:#f9fafb;
}

.chart-box{
background:#e0e7ff;
padding:15px;
border-radius:10px;
}

.total{
margin-top:10px;
font-weight:600;
font-size:14px;
}

</style>
</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">

<div class="logo">
<img src="{{ asset('uploads/assets/blue 2.png') }}">
<div class="logo-text">
<h2>KioStore</h2>
<span>Petugas Panel</span>
</div>
</div>

<div class="menu">
<ul>

<li>
<a href="{{ route('petugas.dashboard') }}"
class="{{ request()->is('petugas/dashboard') ? 'active' : '' }}">
Dashboard
</a>
</li>

<li>
<a href="{{ route('petugas.produk.index') }}"
class="{{ request()->is('petugas/produk*') ? 'active' : '' }}">
Produk
</a>
</li>

<li>
<a href="{{ route('petugas.user.index') }}"
class="{{ request()->is('petugas/user*') ? 'active' : '' }}">
User
</a>
</li>

<li>
<a href="{{ route('petugas.pesanan.index') }}"
class="{{ request()->is('petugas/pesanan*') ? 'active' : '' }}">
Pesanan
</a>
</li>

<li>
<a href="{{ route('petugas.laporan.index') }}"
class="{{ request()->is('petugas/laporan*') ? 'active' : '' }}">
Laporan
</a>
</li>

</ul>
</div>

<form action="{{ route('logout') }}" method="POST">
@csrf
<button class="logout">Log out</button>
</form>

</div>

<!-- MAIN -->
<div class="main">

<div class="topbar">

<h2>Laporan</h2>

<div class="profile">
<span>Hei, {{ auth()->user()->name }} 👋</span>
<div class="profile-circle">
{{ strtoupper(substr(auth()->user()->name,0,2)) }}
</div>
</div>

</div>

<!-- PENJUALAN -->
<div class="card-wrapper">
<div class="card">

<div class="card-header">
<h3>Ringkasan Penjualan</h3>
<a href="{{ route('petugas.laporan.download','penjualan') }}" class="btn-download">
Download
</a>
</div>

<table>

<tr>
<th>ID</th>
<th>Tanggal</th>
<th>Pembeli</th>
<th>Total</th>
</tr>

@foreach($penjualan as $row)

<tr>
<td>#{{ $row->id }}</td>
<td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d-m-Y') }}</td>
<td>{{ $row->pembeli }}</td>
<td>Rp {{ number_format($row->total) }}</td>
</tr>

@endforeach

</table>

</div>
</div>

<!-- STOK -->
<div class="card-wrapper">
<div class="card">

<div class="card-header">
<h3>Laporan Stok</h3>
<a href="{{ route('petugas.laporan.download','stok') }}" class="btn-download">
Download
</a>
</div>

<table>

<tr>
<th>Produk</th>
<th>Stok</th>
</tr>

@foreach($stok as $row)

<tr>
<td>{{ $row->nama }}</td>
<td>{{ $row->stok }}</td>
</tr>

@endforeach

</table>

</div>
</div>

<!-- GRAFIK -->
<div class="card-wrapper">
<div class="card">

<div class="card-header">
<h3>Grafik Penjualan</h3>
<a href="{{ route('petugas.laporan.download','grafik') }}" class="btn-download">
Download
</a>
</div>

<div class="chart-box">
<canvas id="chartPenjualan"></canvas>
</div>

<div class="total">
Total Produk Terjual : {{ number_format($totalTerjual) }}
</div>

</div>
</div>

</div>

<!-- CHART -->
<script>
fetch("{{ route('petugas.laporan.chart') }}")
.then(res => res.json())
.then(data => {

new Chart(document.getElementById('chartPenjualan'),{
type:'bar',
data:{
labels:data.labels,
datasets:[{
data:data.data,
backgroundColor:'#6366f1'
}]
},
options:{
plugins:{
legend:{display:false}
}
}
});

});
</script>

</body>
</html>