<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit User - KioStore</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
body{display:flex;background:#f1f5f9;}
.sidebar{width:220px;background:#fff;height:100vh;padding:20px;position:fixed;border-right:1px solid #e5e7eb;display:flex;flex-direction:column;}
.logo{display:flex;align-items:center;gap:10px;}
.logo img{width:35px;}
.logo-text h2{color:#2563eb;font-size:20px;}
.logo-text span{font-size:13px;color:#6b7280;}
.menu{margin-top:30px;flex:1;}
.menu ul{list-style:none;}
.menu ul li{margin-bottom:12px;}
.menu ul li a{text-decoration:none;color:#374151;padding:10px;display:block;border-radius:8px;transition:.2s;}
.menu ul li a:hover,.menu ul li a.active{background:#e0e7ff;color:#1d4ed8;}
.logout{background:black;color:white;padding:10px;border-radius:8px;border:none;margin-top:auto;cursor:pointer;width:100%;}
.main{margin-left:220px;padding:30px;width:100%;}
.topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:30px;}
.profile{display:flex;align-items:center;gap:10px;}
.profile-circle{width:40px;height:40px;background:#6366f1;border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:bold;}
.form-box{background:white;padding:30px;width:450px;border-radius:15px;box-shadow:0 4px 15px rgba(0,0,0,0.05);}
label{font-size:14px;color:#6b7280;}
input,select{width:100%;padding:12px;margin-top:5px;margin-bottom:18px;border-radius:8px;border:1px solid #e5e7eb;font-size:14px;}
input:focus,select:focus{outline:none;border-color:#2563eb;}
.btn-update{width:100%;background:#2563eb;color:white;padding:12px;border:none;border-radius:8px;cursor:pointer;}
.btn-update:hover{background:#1d4ed8;}
.btn-back{display:inline-block;margin-bottom:20px;background:#6b7280;color:white;padding:8px 14px;border-radius:6px;text-decoration:none;font-size:13px;}
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

<form action="{{ route('logout') }}" method="POST">
@csrf
<button type="submit" class="logout">Log out</button>
</form>

</div>

<!-- MAIN -->
<div class="main">

<div class="topbar">
<h2>Edit User</h2>

<div class="profile">
<span>Hei, {{ auth()->user()->name }} 👋</span>
<div class="profile-circle">
{{ strtoupper(substr(auth()->user()->name,0,2)) }}
</div>
</div>
</div>

<a href="{{ route('petugas.user.index') }}" class="btn-back">
← Kembali
</a>

<div class="form-box">

<form action="{{ route('petugas.user.update',$user->id) }}" method="POST">
@csrf

<label>Nama</label>
<input type="text" name="name" value="{{ $user->name }}" required>

<label>Email</label>
<input type="email" name="email" value="{{ $user->email }}" required>

<label>Status</label>
<select name="status">
<option value="aktif" {{ $user->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
<option value="nonaktif" {{ $user->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
</select>

<button type="submit" class="btn-update">
Update User
</button>

</form>

</div>

</div>

</body>
</html>