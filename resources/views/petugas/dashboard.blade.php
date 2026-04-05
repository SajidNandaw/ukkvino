<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Petugas - KioStore</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif}
body{display:flex;background:#f1f5f9}

/* SIDEBAR */
.sidebar{
width:220px;background:#fff;height:100vh;padding:20px;position:fixed;
border-right:1px solid #e5e7eb;display:flex;flex-direction:column;
}

.logo{display:flex;align-items:center;gap:10px}
.logo img{width:35px}

.logo-text h2{color:#2563eb;font-size:20px}
.logo-text span{font-size:13px;color:#6b7280}

.menu{margin-top:30px;flex:1}
.menu ul{list-style:none}

.menu ul li{margin-bottom:12px}

.menu ul li a{
text-decoration:none;color:#374151;padding:10px;
display:block;border-radius:8px;transition:.2s;
}

.menu ul li a:hover,
.menu ul li a.active{
background:#e0e7ff;color:#1d4ed8;
}

.logout{
background:black;color:white;padding:10px;
border-radius:8px;border:none;margin-top:auto;
cursor:pointer;width:100%;
}

/* MAIN */
.main{
margin-left:220px;padding:30px;width:100%;
}

.topbar{
display:flex;justify-content:space-between;align-items:center;margin-bottom:30px;
}

.profile{
display:flex;align-items:center;gap:10px;
}

.profile-circle{
width:40px;height:40px;background:#6366f1;
border-radius:50%;display:flex;align-items:center;
justify-content:center;color:white;font-weight:bold;
}

/* CARDS */
.cards{
display:flex;gap:20px;margin-bottom:30px;
}

.card{
flex:1;background:white;padding:20px;
border-radius:15px;
box-shadow:0 4px 15px rgba(0,0,0,0.05);
}

.card h3{
font-size:22px;margin-bottom:5px;
}

/* TABLE */
.table-box{
background:white;padding:20px;border-radius:15px;
box-shadow:0 4px 15px rgba(0,0,0,0.05);
margin-bottom:30px;
}

table{
width:100%;border-collapse:collapse;
}

th,td{
padding:12px;border-bottom:1px solid #eee;text-align:left;
}

th{
background:#f9fafb;
}

/* STATUS */
.status{
padding:5px 10px;border-radius:6px;font-size:12px;
}

.pending{background:#ffe97a;}
.dibayar{background:#b9f3c7;}
.dikirim{background:#9db8ff;}
.selesai{background:#c8f7dc;}

/* BOTTOM */
.bottom-section{
display:flex;gap:20px;
}

.statistik{
flex:2;background:white;padding:20px;border-radius:15px;
box-shadow:0 4px 15px rgba(0,0,0,0.05);
}

.produk{
flex:1;background:white;padding:20px;border-radius:15px;
box-shadow:0 4px 15px rgba(0,0,0,0.05);
}

.chart-container{
display:flex;align-items:flex-end;gap:12px;height:220px;margin-top:20px;
}

.bar-item{
display:flex;flex-direction:column;align-items:center;
}

.bar-vertical{
width:25px;background:linear-gradient(to top,#2563eb,#60a5fa);
border-radius:6px;
}

.produk-item{
display:flex;justify-content:space-between;margin-bottom:10px;
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
<a href="{{ route('petugas.dashboard') }}" class="{{ request()->is('petugas/dashboard') ? 'active' : '' }}">
 Dashboard
</a>
</li>

<li>
<a href="{{ route('petugas.produk.index') }}" class="{{ request()->is('petugas/produk*') ? 'active' : '' }}">
 Produk
</a>
</li>

<li>
<a href="{{ route('petugas.user.index') }}" class="{{ request()->is('petugas/user*') ? 'active' : '' }}">
 User
</a>
</li>

<li>
<a href="{{ route('petugas.pesanan.index') }}" class="{{ request()->is('petugas/pesanan*') ? 'active' : '' }}">
 Pesanan
</a>
</li>

<li>
<a href="/petugas/laporan/" class="{{ request()->is('petugas/laporan*') ? 'active' : '' }}">
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
<h2>Dashboard</h2>

<div class="profile">
<span>Hei, Petugas 👋</span>
<div class="profile-circle">PT</div>
</div>
</div>

<!-- CARDS -->
<div class="cards">

<div class="card">
<h3>{{ $totalUser ?? 0 }}</h3>
<p>Total User</p>
</div>

<div class="card">
<h3>Rp {{ number_format($totalProfit ?? 0) }}</h3>
<p>Total Profit</p>
</div>

<div class="card">
<h3>{{ $totalTransaksi ?? 0 }}</h3>
<p>Total Transaksi</p>
</div>

</div>

<!-- TABLE -->
<div class="table-box">

<h3>Riwayat Transaksi</h3>

<table>
<tr>
<th>ID</th>
<th>Tanggal</th>
<th>Pembeli</th>
<th>Total</th>
<th>Status</th>
</tr>

@forelse($riwayat as $row)

<tr>
<td>#{{ $row->id }}</td>
<td>{{ $row->tanggal }}</td>
<td>{{ $row->name }}</td>
<td>Rp {{ number_format($row->total) }}</td>
<td>
<span class="status {{ $row->status }}">
{{ $row->status }}
</span>
</td>
</tr>

@empty

<tr>
<td colspan="5" style="text-align:center;">Belum ada transaksi</td>
</tr>

@endforelse

</table>

</div>

<!-- BOTTOM -->
<div class="bottom-section">

<div class="statistik">

<h3>Statistik Penjualan</h3>

@if(($totalTransaksi ?? 0) == 0)

<p style="margin-top:20px;color:#6b7280;">Belum ada penjualan.</p>

@else

<div class="chart-container">

@php
$bulanNama=[1=>"Jan",2=>"Feb",3=>"Mar",4=>"Apr",5=>"Mei",6=>"Jun",7=>"Jul",8=>"Agu",9=>"Sep",10=>"Okt",11=>"Nov",12=>"Des"];
$maxValue = !empty($dataBulanan) ? max($dataBulanan) : 0;
@endphp

@for($i=1;$i<=12;$i++)

@php
$value = $dataBulanan[$i] ?? 0;
$height = $maxValue > 0 ? ($value / $maxValue) * 200 : 0;
@endphp

<div class="bar-item">
<div class="bar-vertical" style="height:{{ $height }}px;"></div>
<small>{{ $bulanNama[$i] }}</small>
</div>

@endfor

</div>

@endif

</div>

<div class="produk">

<h3>Produk Terlaris</h3>

@forelse($produkTerlaris as $index => $p)

<div class="produk-item">
<span>{{ $p->nama }} ({{ $p->total_terjual }})</span>
<strong>#{{ $index+1 }}</strong>
</div>

@empty

<p style="margin-top:20px;color:#6b7280;">Belum ada produk terjual.</p>

@endforelse

</div>

</div>

</div>

</body>
</html>