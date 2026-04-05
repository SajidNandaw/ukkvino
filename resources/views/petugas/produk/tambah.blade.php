<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Produk - KioStore</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
body{display:flex;background:#f1f5f9;}

/* SIDEBAR */
.sidebar{
width:220px;background:#fff;height:100vh;padding:20px;
position:fixed;left:0;top:0;border-right:1px solid #e5e7eb;
display:flex;flex-direction:column;
}

.logo{display:flex;align-items:center;gap:10px;}
.logo img{width:35px;}

.logo-text h2{color:#2563eb;font-size:20px;}
.logo-text span{font-size:13px;color:#6b7280;}

.menu{margin-top:30px;flex:1;}
.menu ul{list-style:none;}
.menu ul li{margin-bottom:15px;}

.menu ul li a{
text-decoration:none;color:#374151;padding:10px;
display:block;border-radius:8px;transition:0.2s;
}

.menu ul li a:hover,
.menu ul li a.active{
background:#e0e7ff;color:#1d4ed8;
}

.logout{
width:100%;
background:black;color:white;padding:10px;
border:none;border-radius:8px;cursor:pointer;
margin-top:auto;
}

/* MAIN */
.main{
margin-left:220px;
padding:30px;
width:100%;
}

/* TOPBAR */
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
width:40px;height:40px;background:#6366f1;
border-radius:50%;display:flex;align-items:center;
justify-content:center;color:white;font-weight:bold;
}

/* CARD */
.card{
background:white;
padding:30px;
border-radius:15px;
box-shadow:0 4px 15px rgba(0,0,0,0.05);
max-width:500px;
}

.card h3{
margin-bottom:20px;
}

/* FORM */
input,textarea{
width:100%;
padding:12px;
margin-bottom:15px;
border-radius:10px;
border:1px solid #ccc;
font-size:14px;
}

textarea{
resize:none;
height:100px;
}

.btn-submit{
padding:10px 20px;
background:#2563eb;
color:white;
border:none;
border-radius:8px;
cursor:pointer;
}

.btn-back{
padding:10px 20px;
background:#6b7280;
color:white;
border-radius:8px;
text-decoration:none;
margin-left:10px;
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
<a href="{{ route('petugas.laporan.index') }}" class="{{ request()->is('petugas/laporan*') ? 'active' : '' }}">
Laporan
</a>
</li>

</ul>
</div>

<form method="POST" action="{{ route('logout') }}">
@csrf
<button class="logout">Log out</button>
</form>

</div>

<!-- MAIN -->
<div class="main">

<div class="topbar">

<h2>Tambah Produk</h2>

<div class="profile">
<span>Hei, {{ auth()->user()->name }} 👋</span>

<div class="profile-circle">
{{ strtoupper(substr(auth()->user()->name,0,2)) }}
</div>

</div>

</div>

<div class="card">

<h3>Form Tambah Produk</h3>

@if ($errors->any())
<div style="margin-bottom:15px;color:red;">
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<form method="POST" action="{{ route('petugas.produk.store') }}" enctype="multipart/form-data">

@csrf

<input type="text" name="nama" placeholder="Nama Produk" required>

<textarea name="deskripsi" placeholder="Deskripsi Produk" required></textarea>

<input type="number" name="harga" placeholder="Harga" required>

<input type="number" name="stok" placeholder="Stok" required>

<input type="file" name="gambar" required>

<button type="submit" class="btn-submit">
Tambah Produk
</button>

<a href="{{ route('petugas.produk.index') }}" class="btn-back">
Kembali
</a>

</form>

</div>

</div>

</body>
</html>