<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Manajemen Petugas - KioStore</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
body{display:flex;background:#f1f5f9}

/* SIDEBAR */
.sidebar{
width:220px;background:#fff;height:100vh;padding:20px;position:fixed;border-right:1px solid #e5e7eb;display:flex;flex-direction:column;
}
.logo{display:flex;align-items:center;gap:10px}
.logo img{width:35px}
.logo-text h2{color:#2563eb;font-size:20px}
.logo-text span{font-size:13px;color:#6b7280}

.menu{margin-top:30px;flex:1}
.menu ul{list-style:none}
.menu ul li{margin-bottom:15px}
.menu ul li a{
text-decoration:none;color:#374151;padding:10px;display:block;border-radius:8px;transition:.2s;
}
.menu ul li a:hover,
.menu ul li a.active{background:#e0e7ff;color:#1d4ed8}

.logout{
background:black;color:white;padding:10px;text-align:center;border-radius:8px;text-decoration:none;margin-top:auto;border:none;cursor:pointer;width:100%;
}

/* MAIN */
.main{margin-left:220px;padding:30px;width:100%}
.topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:30px}

.profile{display:flex;align-items:center;gap:10px}
.profile-circle{
width:40px;height:40px;background:#6366f1;border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:bold;
}

/* CARD */
.card{
background:white;padding:25px;border-radius:15px;box-shadow:0 4px 15px rgba(0,0,0,.05);
}

.header-card{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px}

.search-box{
padding:10px 14px;border-radius:8px;border:1px solid #ddd;width:260px;
}

.btn-add{
padding:10px 18px;background:#2563eb;color:white;text-decoration:none;border-radius:8px;font-size:14px;
}

/* TABLE */
table{width:100%;border-collapse:collapse}
thead{background:#f9fafb}

th{
padding:16px 20px;text-align:left;font-size:14px;font-weight:600;color:#374151;
}

td{
padding:18px 20px;font-size:14px;color:#4b5563;
}

tbody tr{border-bottom:1px solid #e5e7eb}
tbody tr:last-child{border-bottom:none}

th:nth-child(1),td:nth-child(1){width:60px;text-align:center}
th:nth-child(4),td:nth-child(4){text-align:center}
th:nth-child(5),td:nth-child(5){text-align:center}

/* BADGE */
.badge{padding:6px 16px;border-radius:20px;font-size:12px;font-weight:600;display:inline-block}
.badge-active{background:#dcfce7;color:#166534}
.badge-nonactive{background:#fee2e2;color:#991b1b}

/* BUTTON */
.btn-edit,.btn-delete{
padding:6px 14px;font-size:12px;border-radius:6px;text-decoration:none;display:inline-block;margin:0 4px;
}
.btn-edit{background:#f59e0b;color:white}
.btn-delete{background:#ef4444;color:white}
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
<li><a href="/admin/dashboard">Dashboard</a></li>
<li><a href="/admin/produk">Produk</a></li>
<li><a href="/admin/petugas" class="active">Petugas</a></li>
<li><a href="/admin/backup">Backup</a></li>
<li><a href="/admin/user">User</a></li>
<li><a href="/admin/laporan">Laporan</a></li>
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
<h2>Manajemen Petugas</h2>
<div class="profile">
<span>Hei, Admin 👋</span>
<div class="profile-circle">AD</div>
</div>
</div>

<div class="card">

<div class="header-card">

<!-- SEARCH -->
<form method="GET">
<input 
type="text"
name="search"
class="search-box"
placeholder="Cari nama / email..."
value="{{ request('search') }}"
>
</form>

<a href="/admin/petugas/tambah" class="btn-add">Tambah Petugas</a>

</div>

<table>
<thead>
<tr>
<th>No</th>
<th>Nama</th>
<th>Email</th>
<th>Status</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

@forelse($petugas as $p)
<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $p->name }}</td>

<td>{{ $p->email }}</td>

<td>
@if($p->status == 'aktif')
<span class="badge badge-active">Aktif</span>
@else
<span class="badge badge-nonactive">Nonaktif</span>
@endif
</td>

<td>

<a href="/admin/petugas/edit/{{ $p->id }}" class="btn-edit">Edit</a>

<a href="/admin/petugas/hapus/{{ $p->id }}"
class="btn-delete"
onclick="return confirm('Yakin ingin hapus?')">
Hapus
</a>

</td>

</tr>

@empty

<tr>
<td colspan="5" style="text-align:center;padding:40px;color:#888">
Data tidak ditemukan
</td>
</tr>

@endforelse

</tbody>
</table>

</div>
</div>

</body>
</html>