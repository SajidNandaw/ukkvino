<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Petugas - KioStore</title>
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
.logo-text{display:flex;flex-direction:column}
.logo-text h2{color:#2563eb;font-size:20px}
.logo-text span{font-size:13px;color:#6b7280}

.menu{margin-top:30px;flex:1}
.menu ul{list-style:none}
.menu ul li{margin-bottom:15px}

.menu ul li a{
text-decoration:none;color:#374151;padding:10px;display:block;border-radius:8px;transition:.2s;
}

.menu ul li a:hover,
.menu ul li a.active{
background:#e0e7ff;color:#1d4ed8;
}

/* LOGOUT */
.logout{
background:black;color:white;padding:10px;text-align:center;border-radius:8px;border:none;margin-top:auto;width:100%;cursor:pointer;
}

/* MAIN */
.main{margin-left:220px;padding:30px;width:100%}

.topbar{
display:flex;justify-content:space-between;align-items:center;margin-bottom:30px;
}

.profile{display:flex;align-items:center;gap:10px}

.profile-circle{
width:40px;height:40px;background:#6366f1;border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-weight:bold;
}

/* CARD */
.card{
background:white;padding:25px;border-radius:15px;box-shadow:0 4px 15px rgba(0,0,0,.05);max-width:500px;
}

input{
width:100%;padding:12px;margin-bottom:15px;border:1px solid #ddd;border-radius:8px;
}

.btn-group{
display:flex;gap:10px;
}

.btn-primary{
padding:10px 15px;background:#2563eb;color:white;border:none;border-radius:8px;cursor:pointer;
}

.btn-secondary{
padding:10px 15px;background:#9ca3af;color:white;text-decoration:none;border-radius:8px;
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
<li><a href="/admin/dashboard">Dashboard</a></li>
<li><a href="/admin/produk">Produk</a></li>
<li><a href="/admin/petugas" class="active">Petugas</a></li>
<li><a href="#">Backup</a></li>
<li><a href="#">User</a></li>
<li><a href="#">Laporan</a></li>
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
<h2>Tambah Petugas</h2>

<div class="profile">
<span>Hei, Admin 👋</span>
<div class="profile-circle">AD</div>
</div>

</div>

<div class="card">

@if(session('success'))
<div style="margin-bottom:15px;color:green;">
{{ session('success') }}
</div>
@endif

@if($errors->any())
<div style="margin-bottom:15px;color:red;">
@foreach($errors->all() as $error)
<div>{{ $error }}</div>
@endforeach
</div>
@endif

<form method="POST" action="/admin/petugas/tambah">
@csrf

<input type="text" name="name" placeholder="Nama Petugas" required>

<input type="email" name="email" placeholder="Email" required>

<input type="password" name="password" placeholder="Password" required>

<div class="btn-group">

<button type="submit" class="btn-primary">
Simpan
</button>

<a href="/admin/petugas" class="btn-secondary">
Kembali
</a>

</div>

</form>

</div>

</div>

</body>
</html>