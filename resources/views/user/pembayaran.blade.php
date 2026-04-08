<!DOCTYPE html>
<html>
<head>
<title>Pembayaran</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<style>
*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
background:#dfe7f2;
padding:40px;
}

.container{
width:600px;
margin:auto;
}

/* CARD */
.card{
background:#fff;
border-radius:14px;
padding:20px;
margin-bottom:20px;
box-shadow:0 5px 15px rgba(0,0,0,0.08);
}

/* ITEM */
.item{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:15px;
}

.item-left{
display:flex;
gap:12px;
align-items:center;
}

.item img{
width:60px;
border-radius:8px;
background:#f4f4f4;
padding:5px;
}

/* TOTAL */
.total{
margin-top:10px;
font-size:18px;
font-weight:600;
}

/* REFERENSI */
.ref-box{
display:flex;
justify-content:space-between;
align-items:center;
margin-top:10px;
}

.ref{
font-size:20px;
font-weight:600;
letter-spacing:2px;
}

.copy-btn{
width:45px;
height:45px;
border-radius:50%;
background:#eef2ff;
display:flex;
align-items:center;
justify-content:center;
cursor:pointer;
transition:0.2s;
font-size:18px;
}

.copy-btn:hover{
background:#dbe4ff;
}

/* PETUNJUK */
.instruction{
background:#cfd8ff;
border-radius:12px;
padding:20px;
line-height:1.6;
font-size:14px;
}

/* UPLOAD */
.upload-section{
text-align:center;
margin-top:20px;
}

.upload-label{
display:block;
margin-bottom:15px;
color:#555;
font-size:14px;
}

.upload-btn{
background:#eef2ff;
color:#3b5bdb;
padding:10px 18px;
border-radius:20px;
border:1px solid #d0d7ff;
cursor:pointer;
font-size:14px;
}

.upload-btn:hover{
background:#dbe4ff;
}

.btn{
width:100%;
margin-top:20px;
padding:15px;
background:black;
color:white;
border:none;
border-radius:25px;
font-size:16px;
cursor:pointer;
}

/* BACK BUTTON */
.back-btn{
width:100%;
margin-top:10px;
padding:12px;
background:#ff8a8a;
color:white;
border:none;
border-radius:25px;
font-size:16px;
cursor:pointer;
text-align:center;
text-decoration:none;
display:inline-block;
}

/* POPUP */
.popup{
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.5);
display:none;
justify-content:center;
align-items:center;
}

.popup-box{
background:white;
padding:30px;
border-radius:15px;
text-align:center;
width:350px;
animation:fadeIn 0.3s ease;
}

.popup-box h2{
margin-bottom:10px;
}

.popup-box button{
margin-top:15px;
padding:10px 20px;
background:black;
color:white;
border:none;
border-radius:8px;
cursor:pointer;
}

@keyframes fadeIn{
from{opacity:0; transform:scale(0.8);}
to{opacity:1; transform:scale(1);}
}
</style>

</head>
<body>

<div class="container">

<!-- PRODUK -->
<div class="card">

@php $total_produk = 0; @endphp

@foreach($produk as $p)
@php $total_produk += $p->subtotal; @endphp

<div class="item">
<div class="item-left">
<img src="{{ asset('uploads/'.$p->gambar) }}">
<div>{{ $p->nama }} x{{ $p->qty }}</div>
</div>
<div>
Rp {{ number_format($p->subtotal) }}
</div>
</div>

@endforeach

<hr>

<div>Ongkir : Rp 10.000</div>
<div>Subtotal Produk : Rp {{ number_format($total_produk) }}</div>

<hr>

<div class="total">
Total : Rp {{ number_format($total_produk + 10000) }}
</div>

</div>

<!-- REFERENSI -->
<div class="card">
<b>Referensi Pembayaran</b>
<hr>
<div class="ref-box">
<div class="ref" id="ref">
{{ $data->kode_referensi ?? '0936374838373' }}
</div>
<div class="copy-btn" onclick="copyRef()">📋</div>
</div>
</div>

<!-- PETUNJUK -->
<div class="instruction">
<b>Cara Transfer via M-Banking:</b>
<br><br>
1. Buka aplikasi M-Banking kamu.<br>
2. Login menggunakan akunmu.<br>
3. Pilih menu <b>Transfer</b>.<br>
4. Pilih <b>Transfer ke Bank</b>.<br>
5. Masukkan nomor rekening tujuan dengan benar.<br>
6. Masukkan jumlah sesuai total pembayaran.<br>
7. Cek kembali semua data transaksi.<br>
8. Masukkan PIN atau OTP yang diminta.<br>
9. Selesai, simpan bukti pembayaran untuk konfirmasi.<br>
10. Pastikan bukti pembayaran diunggah melalui form di bawah agar pesanan segera diproses.<br>
</div>

<!-- UPLOAD -->
<div class="card">

@if(!$data->bukti)
<form method="POST" action="{{ route('pembayaran.upload') }}" enctype="multipart/form-data" onsubmit="return handleSubmit()">
@csrf
<input type="hidden" name="transaksi_id" value="{{ $data->id }}">
<div class="upload-section">
<label class="upload-label">
Upload bukti pembayaran untuk konfirmasi
</label>
<input type="file" id="fileInput" name="bukti" hidden required>
<button type="button" class="upload-btn" onclick="document.getElementById('fileInput').click()">
📥 Upload bukti pembayaran
</button>
<button type="submit" class="btn">
Kirim
</button>
</div>
</form>
@endif

@if($data->metode == 'transfer' && !$data->bukti)
<a href="{{ route('user.riwayat') }}" class="back-btn">
Kembali ke Riwayat
</a>
@endif

</div>

</div>

<!-- POPUP -->
<div class="popup" id="popup">
<div class="popup-box">
<h2>✅ Berhasil</h2>
<p>Bukti pembayaran berhasil dikirim.<br>
Pesanan akan segera diproses.</p>
<button onclick="goDashboard()">OK</button>
</div>
</div>

<script>
/* COPY */
function copyRef(){
let text = document.getElementById("ref").innerText;
navigator.clipboard.writeText(text);
alert("Nomor referensi disalin!");
}

/* SUBMIT + POPUP */
function handleSubmit(){
let file = document.getElementById('fileInput').files.length;
if(file === 0){
alert("Upload bukti pembayaran dulu!");
return false;
}
// tampilkan popup
document.getElementById("popup").style.display = "flex";
// delay submit biar popup keliatan
setTimeout(()=>{
document.forms[0].submit();
}, 1500);
return false;
}

function goDashboard(){
window.location.href = "{{ route('user.dashboard') }}";
}
</script>

</body>
</html>