<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Manajemen User - KioStore</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
body{display:flex;background:#f1f5f9;}

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

.logo{display:flex;align-items:center;gap:10px;}
.logo img{width:35px;}

.logo-text{display:flex;flex-direction:column;}
.logo-text h2{color:#2563eb;font-size:20px;}
.logo-text span{font-size:13px;color:#6b7280;}

.menu{margin-top:30px;flex:1;}
.menu ul{list-style:none;}
.menu ul li{margin-bottom:15px;}

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

/* LOGOUT (DISAMAKAN DENGAN DASHBOARD ADMIN) */
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

.profile{display:flex;align-items:center;gap:10px;}

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
.card{
background:white;
padding:20px;
border-radius:15px;
box-shadow:0 4px 15px rgba(0,0,0,0.05);
}

.header-card{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:20px;
flex-wrap:wrap;
gap:10px;
}

.search-box{
padding:10px;
border-radius:8px;
border:1px solid #ddd;
width:250px;
}

/* TABLE */

table{
width:100%;
border-collapse:collapse;
}

th,td{
padding:12px;
text-align:left;
border-bottom:1px solid #eee;
}

th{background:#f9fafb;}

.no-data{
text-align:center;
padding:25px;
color:#6b7280;
}

/* STATUS BADGE */

.badge{
padding:5px 12px;
border-radius:20px;
font-size:12px;
font-weight:600;
}

.badge-active{
background:#dcfce7;
color:#166534;
}

.badge-nonactive{
background:#fee2e2;
color:#991b1b;
}

/* BUTTON */

.btn-edit{
padding:5px 10px;
background:#f59e0b;
color:white;
border-radius:6px;
text-decoration:none;
font-size:12px;
border:none;
}

.btn-delete{
padding:5px 10px;
background:#ef4444;
color:white;
border-radius:6px;
text-decoration:none;
font-size:12px;
border:none;
cursor:pointer;
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
<span>Dashboard</span>
</div>
</div>

<div class="menu">
<ul>

<li>
<a href="{{ route('admin.dashboard') }}">Dashboard</a>
</li>

<li>
<a href="{{ route('admin.produk.index') }}">Produk</a>
</li>

<li>
<a href="{{ route('admin.petugas.index') }}">Petugas</a>
</li>

<li>
<a href="{{ route('admin.backup') }}">Backup</a>
</li>

<li>
<a href="{{ route('admin.user.index') }}" class="active">User</a>
</li>

<li>
<a href="{{ route('admin.laporan.index') }}">Laporan</a>
</li>

</ul>
</div>

<form action="{{ route('logout') }}" method="POST">
@csrf
<button type="submit" class="logout">
Log out
</button>
</form>

</div>

<!-- MAIN -->
<div class="main">

<div class="topbar">

<h2>Manajemen User</h2>

<div class="profile">

<span>Hei, {{ auth()->user()->name }} 👋</span>

<div class="profile-circle">
{{ strtoupper(substr(auth()->user()->name,0,2)) }}
</div>

</div>

</div>

<div class="card">

<div class="header-card">

<form method="GET">

<input
type="text"
name="search"
class="search-box"
placeholder="Cari User..."
value="{{ $search }}"
>

</form>

</div>

<table>

<tr>
<th>Nama</th>
<th>Email</th>
<th>Status</th>
<th>Aksi</th>
</tr>

@if($users->count() == 0)

<tr>
<td colspan="4" class="no-data">
User tidak ditemukan
</td>
</tr>

@endif

@foreach($users as $row)

<tr>

<td>{{ $row->name }}</td>

<td>{{ $row->email }}</td>

<td>

@if($row->status == "aktif")

<span class="badge badge-active">
Aktif
</span>

@else

<span class="badge badge-nonactive">
Nonaktif
</span>

@endif

</td>

<td>

<a href="{{ route('admin.user.edit',$row->id) }}" class="btn-edit">
Edit
</a>

<form
action="{{ route('admin.user.destroy',$row->id) }}"
method="POST"
style="display:inline"
>

@csrf
@method('DELETE')

<button
onclick="return confirm('Yakin ingin menghapus user ini?')"
class="btn-delete"
>
Hapus
</button>

</form>

</td>

</tr>

@endforeach

</table>

</div>

</div>

</body>
</html>