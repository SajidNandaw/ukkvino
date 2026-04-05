<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pesanan - KioStore</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif}
body{display:flex;background:#f1f5f9}
.sidebar{width:220px;background:#fff;height:100vh;padding:20px;position:fixed;border-right:1px solid #e5e7eb;display:flex;flex-direction:column;}
.logo{display:flex;align-items:center;gap:10px} .logo img{width:35px} .logo-text h2{color:#2563eb;font-size:20px} .logo-text span{font-size:13px;color:#6b7280}
.menu{margin-top:30px;flex:1} .menu ul{list-style:none} .menu ul li{margin-bottom:12px} .menu ul li a{text-decoration:none;color:#374151;padding:10px;display:block;border-radius:8px;} .menu ul li a.active{background:#e0e7ff;color:#1d4ed8;}
.logout{background:black;color:white;padding:10px;border-radius:8px;border:none;margin-top:auto;cursor:pointer;width:100%;}
.main{margin-left:220px;padding:30px;width:100%;}
.topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:30px;}
.profile{display:flex;align-items:center;gap:10px;}
.profile-circle{width:40px;height:40px;background:#6366f1;border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:bold;}
.table-box{background:white;padding:20px;border-radius:15px;box-shadow:0 4px 15px rgba(0,0,0,0.05);margin-bottom:40px;}
table{width:100%;border-collapse:collapse;}
th,td{padding:12px;border-bottom:1px solid #eee;text-align:left;}
th{background:#f9fafb;}
.status{padding:5px 10px;border-radius:6px;font-size:12px;font-weight:500;}
.menunggu_pembayaran{background:#ffe97a;}
.dibayar{background:#b9f3c7;}
.diproses{background:#ffe97a;}
.dikirim{background:#9db8ff;}
.selesai{background:#c8f7dc;}
.batal{background:#ff8a8a;}
.btn{padding:6px 10px;border-radius:6px;font-size:12px;border:none;cursor:pointer;margin-right:5px;color:white;text-decoration:none;display:inline-block;}
.btn-kirim{background:#3b82f6;}
.btn-selesai{background:#22c55e;}
.btn-detail{background:#6b7280;}
form{display:inline;}
</style>
</head>
<body>

<div class="sidebar">
<div class="logo">
<img src="{{ asset('uploads/assets/blue 2.png') }}">
<div class="logo-text"><h2>KioStore</h2><span>Petugas Panel</span></div>
</div>
<div class="menu">
<ul>
<li><a href="{{ route('petugas.dashboard') }}">Dashboard</a></li>
<li><a href="{{ route('petugas.produk.index') }}">Produk</a></li>
<li><a href="{{ route('petugas.user.index') }}">User</a></li>
<li><a href="{{ route('petugas.pesanan.index') }}" class="active">Pesanan</a></li>
<li><a href="{{ route('petugas.laporan.index') }}">Laporan</a></li>
</ul>
</div>
<form action="{{ route('logout') }}" method="POST">@csrf<button class="logout">Log out</button></form>
</div>

<div class="main">
<div class="topbar"><h2>Kelola Pesanan</h2><div class="profile"><span>Petugas 👋</span><div class="profile-circle">PT</div></div></div>

<div class="table-box">
<h3>Daftar Pesanan Aktif</h3>
<table>
<tr><th>ID</th><th>User</th><th>Total</th><th>Status</th><th>Aksi</th></tr>
@forelse($pesanan as $p)
@php
$now = \Carbon\Carbon::now(); $orderTime = \Carbon\Carbon::parse($p->tanggal); $diffHours = $now->diffInHours($orderTime);
$statusClass=''; $statusText='';
if($p->metode=='transfer' && $p->status=='pending' && $diffHours<24){ $statusClass='menunggu_pembayaran'; $statusText='Menunggu Pembayaran'; }
elseif($p->status=='pending' && $p->metode=='cod'){ $statusClass='menunggu_pembayaran'; $statusText='Menunggu Proses'; }
elseif($p->status=='dibayar'){ $statusClass='dibayar'; $statusText='Sedang Diproses'; }
elseif($p->status=='diproses'){ $statusClass='diproses'; $statusText='Sedang Diproses'; }
elseif($p->status=='dikirim'){ $statusClass='dikirim'; $statusText='Dalam Pengiriman'; }
elseif($p->status=='batal'){ $statusClass='batal'; $statusText='Dibatalkan'; }
else{ $statusClass='menunggu_pembayaran'; $statusText='Status Tidak Diketahui'; }
@endphp
<tr>
<td>#{{ $p->id }}</td>
<td>{{ $p->name ?? '-' }}</td>
<td>Rp {{ number_format($p->total) }}</td>
<td><span class="status {{ $statusClass }}">{{ $statusText }}</span></td>
<td>
<a href="{{ route('petugas.pesanan.detail',$p->id) }}" class="btn btn-detail">Detail</a>
@if($p->status=='dibayar'||$p->status=='diproses')
<form action="{{ route('petugas.pesanan.kirim',$p->id) }}" method="POST">@csrf<button class="btn btn-kirim">Kirim</button></form>
@endif
@if($p->status=='dikirim')
<form action="{{ route('petugas.pesanan.selesai',$p->id) }}" method="POST">@csrf<button class="btn btn-selesai">Selesai</button></form>
@endif
</td></tr>
@empty
<tr><td colspan="5" style="text-align:center;">Belum ada pesanan aktif</td></tr>
@endforelse
</table>
</div>

<div class="table-box">
<h3>Riwayat Pesanan</h3>
<table>
<tr><th>ID</th><th>User</th><th>Total</th><th>Status</th><th>Aksi</th></tr>
@php $riwayat = $riwayat ?? collect([]); @endphp
@forelse($riwayat as $r)
@php
$now = \Carbon\Carbon::now(); $orderTime = \Carbon\Carbon::parse($r->tanggal); $diffHours = $now->diffInHours($orderTime);
$statusClass=''; $statusText='';
if($r->status=='selesai'){ $statusClass='selesai'; $statusText='Selesai'; }
elseif($r->status=='batal'){ $statusClass='batal'; $statusText='Dibatalkan'; }
elseif($r->status=='dibayar'){ $statusClass='dibayar'; $statusText='Sedang Diproses'; }
elseif($r->status=='diproses'){ $statusClass='diproses'; $statusText='Sedang Diproses'; }
elseif($r->status=='dikirim'){ $statusClass='dikirim'; $statusText='Dalam Pengiriman'; }
else{ $statusClass='menunggu_pembayaran'; $statusText='Status Tidak Diketahui'; }
@endphp
<tr>
<td>#{{ $r->id }}</td>
<td>{{ $r->name ?? '-' }}</td>
<td>Rp {{ number_format($r->total) }}</td>
<td><span class="status {{ $statusClass }}">{{ $statusText }}</span></td>
<td><a href="{{ route('petugas.pesanan.detail',$r->id) }}" class="btn btn-detail">Detail</a></td>
</tr>
@empty
<tr><td colspan="5" style="text-align:center;">Belum ada riwayat pesanan</td></tr>
@endforelse
</table>
</div>

</div>
</body>
</html>