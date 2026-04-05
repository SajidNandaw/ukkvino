<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Produk</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<style>
*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
background:#f1f5f9;
display:flex;
justify-content:center;
align-items:center;
height:100vh;
}

.container{
background:white;
padding:40px;
width:400px;
border-radius:15px;
box-shadow:0 5px 20px rgba(0,0,0,0.1);
}

h2{
margin-bottom:25px;
text-align:center;
}

input, textarea{
width:100%;
padding:12px;
margin-bottom:15px;
border-radius:8px;
border:1px solid #ccc;
font-size:14px;
}

textarea{
resize:none;
height:90px;
}

button{
width:100%;
padding:12px;
background:#2563eb;
color:white;
border:none;
border-radius:8px;
cursor:pointer;
font-weight:500;
}

button:hover{
background:#1d4ed8;
}

.back{
display:block;
margin-top:15px;
text-align:center;
font-size:14px;
text-decoration:none;
color:#555;
}
</style>
</head>

<body>

<div class="container">

<h2>Tambah Produk</h2>

@if ($errors->any())
<div style="margin-bottom:15px;color:red;">
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<form method="POST" action="/admin/produk/tambah" enctype="multipart/form-data">

@csrf

<input type="text"
name="nama"
placeholder="Nama Produk"
required>

<textarea
name="deskripsi"
placeholder="Deskripsi Produk"
required></textarea>

<input type="number"
name="harga"
placeholder="Harga"
required>

<input type="number"
name="stok"
placeholder="Stok"
required>

<input type="file"
name="gambar"
required>

<button type="submit">
Tambah Produk
</button>

</form>

<a href="/admin/produk" class="back">
← Kembali ke Manajemen Produk
</a>

</div>

</body>
</html>