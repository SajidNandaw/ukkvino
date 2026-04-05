<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Backup Data - KioStore</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

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

/* LOGOUT (SAMA SEPERTI DASHBOARD ADMIN) */

.logout{
background:black;
color:white;
padding:10px;
text-align:center;
border-radius:8px;
text-decoration:none;
margin-top:auto;
border:none;
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

/* CARD */

.card{
background:white;
padding:25px;
border-radius:15px;
box-shadow:0 4px 15px rgba(0,0,0,0.05);
margin-bottom:30px;
}

.card h3{
margin-bottom:20px;
font-size:18px;
}

/* TABLE */

table{
width:100%;
border-collapse:collapse;
}

thead{
background:#f9fafb;
}

th{
padding:16px 20px;
text-align:left;
font-size:14px;
font-weight:600;
color:#374151;
}

td{
padding:18px 20px;
font-size:14px;
color:#4b5563;
}

tbody tr{
border-bottom:1px solid #e5e7eb;
}

tbody tr:last-child{
border-bottom:none;
}

/* BADGE */

.badge-warning{
padding:6px 14px;
background:#f59e0b;
color:white;
border-radius:20px;
font-size:12px;
}

.badge-success{
padding:6px 14px;
background:#22c55e;
color:white;
border-radius:20px;
font-size:12px;
}

/* BUTTON */

.btn-restore{
padding:6px 14px;
background:#2563eb;
color:white;
border-radius:6px;
text-decoration:none;
font-size:12px;
}

.btn-download{
padding:6px 14px;
border:1px solid #ddd;
border-radius:6px;
text-decoration:none;
font-size:12px;
background:#f9fafb;
}

.btn-download:hover{
background:#e5e7eb;
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
<li><a href="/admin/dashboard">Dashboard</a></li>
<li><a href="/admin/produk">Produk</a></li>
<li><a href="/admin/petugas">Petugas</a></li>
<li><a href="/admin/backup" class="active">Backup</a></li>
<li><a href="/admin/user">User</a></li>
<li><a href="/admin/laporan">Laporan</a></li>
</ul>
</div>

<!-- LOGOUT -->

<form action="{{ route('logout') }}" method="POST">
@csrf
<button type="submit" class="logout">
Log out
</button>
</form>

</div>

<div class="main">

<div class="topbar">
<h2>Backup Data</h2>
</div>

<!-- DATA BELUM DIRESTORE -->

<div class="card">

<h3>Data Belum Direstore</h3>

<table>

<thead>
<tr>
<th>Tanggal Hapus</th>
<th>Jenis Data</th>
<th>Status</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

@foreach($backup as $row)

<tr>

<td>{{ \Carbon\Carbon::parse($row->deleted_at)->format('d F Y H:i') }}</td>

<td>{{ ucfirst($row->table_name) }}</td>

<td>
<span class="badge-warning">Belum Direstore</span>
</td>

<td>

<a href="{{ route('admin.backup.restore',$row->id) }}"
class="btn-restore"
onclick="return confirm('Restore data ini?')">

Restore

</a>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>


<!-- RIWAYAT RESTORE -->

<div class="card">

<h3>Riwayat Restore</h3>

<table>

<thead>
<tr>
<th>Tanggal Restore</th>
<th>Jenis Data</th>
<th>Status</th>
<th>Download</th>
</tr>
</thead>

<tbody>

@foreach($history as $row)

<tr>

<td>{{ \Carbon\Carbon::parse($row->restored_at)->format('d F Y H:i') }}</td>

<td>{{ ucfirst($row->table_name) }}</td>

<td>
<span class="badge-success">Sudah Direstore</span>
</td>

<td>

<a href="{{ route('admin.backup.download',$row->id) }}" class="btn-download">
⬇ Download
</a>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

</body>
</html>