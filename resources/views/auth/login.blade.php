<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login | KioStore</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
*{
    box-sizing:border-box;
    margin:0;
    padding:0;
    font-family:'Poppins',sans-serif;
}

body{
    background:#eaf2ff;
}

.container{
    display:flex;
    height:100vh;
}

.left{
    width:50%;
    position:relative;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:40px;
}

.brand-top{
    position:absolute;
    top:40px;
    left:50px;
    font-size:40px;
    font-weight:700;
    color:#2d7cff;
}

/* Tombol Kembali di kiri atas */
.back-btn-left{
    position:absolute;
    top:100px;
    left:50px;
    display:inline-block;
    padding:10px 18px;
    background:#f1f1f1;
    color:#2d7cff;
    border-radius:12px;
    text-decoration:none;
    font-weight:600;
    transition:0.3s;
}

.back-btn-left:hover{
    background:#dbe6f8;
}

.left-content{
    text-align:center;
}

.left-content img{
    width:400px;
    margin-bottom:-75px;
}

.left-content p{
    font-size:16px;
    color:#555;
    font-style:italic;
}

.right{
    width:50%;
    display:flex;
    justify-content:center;
    align-items:center;
}

.card{
    background:#ffffff;
    width:500px;
    padding:50px;
    border-radius:28px;
    box-shadow:0 20px 45px rgba(0,0,0,0.15);
}

.card h2{
    font-size:32px;
    font-weight:700;
    text-align:center;
    margin-bottom:10px;
}

.card p{
    text-align:center;
    font-size:15px;
    margin-bottom:35px;
}

.card a{
    color:#2d7cff;
    text-decoration:none;
    font-weight:500;
}

input{
    width:100%;
    padding:16px;
    margin-bottom:22px;
    border-radius:16px;
    border:1px solid #dcdcdc;
    background:#f9f9f9;
    font-size:14px;
}

button{
    width:100%;
    padding:16px;
    background:#2d7cff;
    color:white;
    border:none;
    border-radius:18px;
    font-size:18px;
    font-weight:600;
    cursor:pointer;
}

.error{
    background:#ffdede;
    color:#b40000;
    padding:12px;
    border-radius:12px;
    margin-bottom:20px;
    text-align:center;
    font-size:14px;
}
</style>
</head>

<body>

<div class="container">

<div class="left">

<div class="brand-top">KioStore</div>

<!-- Tombol Kembali ke Katalog di kiri -->
<a href="{{ route('public.katalog') }}" class="back-btn-left">← Kembali ke Beranda Produk</a>

<div class="left-content">
<img src="{{ asset('uploads/assets/blue 2.png') }}">
<p>Gabung sekarang, mulai ceritamu bersama KioStore.</p>
</div>

</div>

<div class="right">
<div class="card">

<h2>Login Disini</h2>
<p>Belum punya akun? <a href="{{ route('register') }}">Daftar disini</a></p>

@if(session('error'))
<div class="error">
{{ session('error') }}
</div>
@endif

<form method="POST" action="{{ route('login.post') }}">
@csrf

<input type="email" name="email" placeholder="Masukkan Email" required>

<input type="password" name="password" placeholder="Masukkan Password" required>

<button type="submit">Login</button>

</form>

</div>
</div>

</div>

</body>
</html>