<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard - KioStore</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif}
body{display:flex;background:#f1f5f9}

/* ================= SIDEBAR ================= */

.sidebar{
width:220px;
background:#fff;
height:100vh;
padding:20px;
position:fixed;
left:0;
top:0;
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

.logo-text{
display:flex;
flex-direction:column;
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
margin-bottom:15px;
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

/* ================= LOGOUT ================= */

.logout-form{
margin-top:auto;
}

.logout{
width:100%;
background:black;
color:white;
padding:10px;
border:none;
border-radius:8px;
cursor:pointer;
font-size:14px;
}

.logout:hover{
opacity:0.9;
}

/* ================= MAIN ================= */

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

/* ================= CARDS ================= */

.cards{
display:flex;
gap:20px;
margin-bottom:30px;
}

.card{
flex:1;
background:white;
padding:20px;
border-radius:15px;
box-shadow:0 4px 15px rgba(0,0,0,0.05);
}

.card h3{
font-size:22px;
margin-bottom:5px;
}

/* ================= TABLE ================= */

.table-box,
.statistik,
.produk{
background:white;
padding:20px;
border-radius:15px;
box-shadow:0 4px 15px rgba(0,0,0,0.05);
margin-bottom:30px;
}

table{
width:100%;
border-collapse:collapse;
}

th,td{
padding:12px;
border-bottom:1px solid #eee;
text-align:left;
}

th{
background:#f9fafb;
}

/* ================= STATISTIK ================= */

.bottom-section{
display:flex;
gap:20px;
}

.statistik{
flex:2;
}

.produk{
flex:1;
}

.chart-container{
display:flex;
align-items:flex-end;
gap:12px;
height:220px;
margin-top:20px;
}

.bar-item{
display:flex;
flex-direction:column;
align-items:center;
}

.bar-vertical{
width:25px;
background:linear-gradient(to top,#2563eb,#60a5fa);
border-radius:6px;
}

.produk-item{
display:flex;
justify-content:space-between;
margin-bottom:10px;
}
</style>
</head>

<body>

<div class="sidebar">

<div class="logo">
<img src="{{ asset('uploads/assets/blue 2.png') }}">
<div class="logo-text">
<h2>KioStore</h2>
<span>Dashboard</span>
</div>
</div>

<div class="menu">
<ul>
<li><a href="/admin/dashboard" class="active">Dashboard</a></li>
<li><a href="/admin/produk">Produk</a></li>
<li><a href="/admin/petugas">Petugas</a></li>
<li><a href="/admin/backup">Backup</a></li>
<li><a href="/admin/user">User</a></li>
<li><a href="/admin/laporan">Laporan</a></li>
</ul>
</div>

<form method="POST" action="{{ route('logout') }}" class="logout-form">
@csrf
<button type="submit" class="logout">Log out</button>
</form>

</div>


<div class="main">

<div class="topbar">
<h2>Dashboard</h2>

<div class="profile">
<span>Hei, {{ Auth::user()->name }} 👋</span>
<div class="profile-circle">
{{ strtoupper(substr(Auth::user()->name,0,2)) }}
</div>
</div>

</div>


<div class="cards">

<div class="card">
<h3>{{ $totalUser }}</h3>
<p>Total User</p>
</div>

<div class="card">
<h3>Rp {{ number_format($totalProfit) }}</h3>
<p>Total Profit</p>
</div>

<div class="card">
<h3>{{ $totalTransaksi }}</h3>
<p>Total Transaksi</p>
</div>

</div>


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

@foreach($riwayat as $row)

<tr>
<td>#{{ $row->id }}</td>
<td>{{ $row->tanggal }}</td>
<td>{{ $row->name }}</td>
<td>Rp {{ number_format($row->total) }}</td>
<td>{{ $row->status }}</td>
</tr>

@endforeach

</table>

</div>


<div class="bottom-section">

<div class="statistik">

<h3>Statistik Penjualan</h3>

@if($totalTransaksi == 0)

<p style="margin-top:20px;color:#6b7280;">Belum ada penjualan.</p>

@else

<div class="chart-container">

@php
$bulanNama=[1=>"Jan",2=>"Feb",3=>"Mar",4=>"Apr",5=>"Mei",6=>"Jun",7=>"Jul",8=>"Agu",9=>"Sep",10=>"Okt",11=>"Nov",12=>"Des"];
$maxValue=max($statistik->toArray() ?: [0]);
@endphp

@for($i=1;$i<=12;$i++)

@php
$value=$statistik[$i] ?? 0;
$height=$maxValue>0 ? ($value/$maxValue)*200 : 0;
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

@if($terlaris->count()==0)

<p style="margin-top:20px;color:#6b7280;">Belum ada produk terjual.</p>

@else

@foreach($terlaris as $key => $row)

<div class="produk-item">
<span>{{ $row->nama }} ({{ $row->total_terjual }})</span>
<strong>#{{ $key+1 }}</strong>
</div>

@endforeach

@endif

</div>

</div>

</div>

</body>
</html>