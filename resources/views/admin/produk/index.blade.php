```html
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Manajemen Produk - KioStore</title>
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

/* logout */

.logout{
width:100%;
background:black;
color:white;
padding:10px;
text-align:center;
border-radius:8px;
border:none;
cursor:pointer;
font-size:14px;
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

/* ================= CARD ================= */

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
gap:10px;
flex-wrap:wrap;
}

.search-box{
padding:10px;
border-radius:8px;
border:1px solid #ddd;
width:250px;
}

.btn-add{
padding:10px 15px;
background:#2563eb;
color:white;
text-decoration:none;
border-radius:8px;
font-size:14px;
}

/* ================= TABLE ================= */

.table-wrapper{
overflow-x:auto;
}

table{
width:100%;
border-collapse:collapse;
margin-top:10px;
}

th,td{
padding:12px;
text-align:left;
border-bottom:1px solid #eee;
}

th{
background:#f9fafb;
}

.product-img{
width:60px;
border-radius:8px;
}

/* ================= BUTTON ================= */

.btn-edit{
padding:6px 12px;
background:#f59e0b;
color:white;
border-radius:6px;
text-decoration:none;
font-size:12px;
margin-right:5px;
transition:0.2s;
}

.btn-edit:hover{
background:#d97706;
}

.btn-delete{
padding:6px 12px;
background:#ef4444;
color:white;
border-radius:6px;
text-decoration:none;
font-size:12px;
transition:0.2s;
}

.btn-delete:hover{
background:#dc2626;
}

.no-data{
text-align:center;
padding:30px;
color:#6b7280;
}

</style>
</head>

<body>

<!-- ================= SIDEBAR ================= -->

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
<a href="/admin/dashboard">Dashboard</a>
</li>

<li>
<a href="/admin/produk" class="active">Produk</a>
</li>

<li>
<a href="/admin/petugas">Petugas</a>
</li>

<li>
<a href="/admin/backup">Backup</a>
</li>

<li>
<a href="/admin/user">User</a>
</li>

<li>
<a href="/admin/laporan">Laporan</a>
</li>

</ul>
</div>

<form method="POST" action="{{ route('logout') }}">
@csrf
<button class="logout">Log out</button>
</form>

</div>

<!-- ================= MAIN ================= -->

<div class="main">

<div class="topbar">

<h2>Manajemen Produk</h2>

<div class="profile">

<span>Hei, {{ Auth::user()->name }} 👋</span>

<div class="profile-circle">
{{ strtoupper(substr(Auth::user()->name,0,2)) }}
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
placeholder="Cari Produk..."
value="{{ request('search') }}">
</form>

<a href="/admin/produk/tambah" class="btn-add">
+ Tambah Produk
</a>

</div>

<div class="table-wrapper">

<table>

<tr>
<th>Gambar</th>
<th>Nama</th>
<th>Deskripsi</th>
<th>Stok</th>
<th>Harga</th>
<th>Aksi</th>
</tr>

@if($produk->count() == 0)

<tr>
<td colspan="6" class="no-data">
Produk tidak ditemukan
</td>
</tr>

@endif

@foreach($produk as $row)

<tr>

<td>
@if($row->gambar)
<img src="{{ asset('uploads/'.$row->gambar) }}" class="product-img">
@endif
</td>

<td>{{ $row->nama }}</td>

<td>{{ \Illuminate\Support\Str::limit($row->deskripsi,50) }}</td>

<td>{{ $row->stok }}</td>

<td>Rp {{ number_format($row->harga) }}</td>

<td>

<a href="/admin/produk/edit/{{ $row->id }}" class="btn-edit">
Edit
</a>

<a href="/admin/produk/hapus/{{ $row->id }}"
class="btn-delete"
onclick="return confirm('Yakin hapus produk?')">
Hapus
</a>

</td>

</tr>

@endforeach

</table>

</div>

</div>

</div>

</body>
</html>
```
