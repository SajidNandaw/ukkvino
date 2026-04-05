<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Detail Pesanan - KioStore</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
body{background:#f0f2f5;}

/* SIDEBAR */
.sidebar{
width:220px;background:#fff;height:100vh;padding:20px;position:fixed;
border-right:1px solid #e2e8f0;display:flex;flex-direction:column;
}
.logo{display:flex;align-items:center;gap:10px;margin-bottom:25px;}
.logo img{width:35px;}
.logo-text h2{color:#2563eb;font-size:20px;}
.logo-text span{font-size:12px;color:#6b7280;}

.menu{flex:1;}
.menu ul{list-style:none;padding:0;}
.menu ul li{margin-bottom:10px;}
.menu ul li a{
text-decoration:none;color:#374151;padding:10px;
display:block;border-radius:10px;
transition:0.2s;
}
.menu ul li a:hover{background:#e0e7ff;color:#1d4ed8;}
.menu ul li a.active{background:#e0e7ff;color:#1d4ed8;font-weight:500;}

.logout{
background:#111;color:white;padding:10px;
border-radius:10px;border:none;margin-top:auto;
cursor:pointer;width:100%;
transition:0.2s;
}
.logout:hover{opacity:0.9;}

/* MAIN */
.main{
margin-left:220px;padding:30px;
}

/* CARD */
.card{
background:white;padding:25px;border-radius:15px;
box-shadow:0 6px 20px rgba(0,0,0,0.05);
margin-bottom:20px;
transition:0.2s;
}
.card:hover{box-shadow:0 8px 25px rgba(0,0,0,0.08);}

.title{
font-size:24px;font-weight:600;margin-bottom:15px;
color:#111;
}

/* INFO GRID */
.info-grid{
display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:15px;margin-bottom:20px;
}
.info-box{
background:#f9fafb;padding:15px;border-radius:12px;
}
.info-box b{display:block;margin-bottom:5px;color:#374151;}
.info-box span{color:#6b7280;}

/* ITEM LIST */
.item{
display:flex;align-items:center;gap:15px;margin-bottom:15px;
border-bottom:1px solid #eee;padding-bottom:12px;
}
.item img{
width:70px;height:70px;
object-fit:cover;
border-radius:10px;
background:#eee;
}
.item-info{
flex:1;font-size:14px;
}

/* STATUS */
.status{
padding:6px 12px;border-radius:8px;font-size:13px;
display:inline-block;margin-top:10px;
font-weight:500;
}
.dikirim{background:#dbeafe;color:#1e40af;}
.selesai{background:#d1fae5;color:#065f46;}
.pending{background:#fef3c7;color:#92400e;}

/* BUTTONS */
.btn{
display:inline-block;margin-top:20px;padding:10px 18px;
background:#3b82f6;color:white;border-radius:10px;border:none;
cursor:pointer;transition:0.2s;
}
.btn:hover{opacity:0.9;}
.btn-back{
display:inline-block;margin-top:20px;margin-left:10px;padding:10px 18px;
background:#6b7280;color:white;border-radius:10px;text-decoration:none;
transition:0.2s;
}
.btn-back:hover{opacity:0.9;}
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
            <li><a href="{{ route('petugas.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('petugas.produk.index') }}">Produk</a></li>
            <li><a href="{{ route('petugas.user.index') }}">User</a></li>
            <li><a href="{{ route('petugas.pesanan.index') }}" class="active">Pesanan</a></li>
            <li><a href="{{ route('petugas.laporan.index') }}">Laporan</a></li>
        </ul>
    </div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="logout">Log out</button>
    </form>
</div>

<!-- MAIN -->
<div class="main">

<div class="card">
    <div class="title">
        Detail Pesanan #{{ $transaksi->id }}
    </div>

    <div class="info-grid">
        <div class="info-box">
            <b>Nama User</b>
            <span>{{ $transaksi->user->name ?? '-' }}</span>
        </div>
        <div class="info-box">
            <b>Tanggal</b>
            <span>{{ \Carbon\Carbon::parse($transaksi->tanggal)->translatedFormat('d F Y') }}</span>
        </div>
        <div class="info-box">
            <b>Total</b>
            <span>Rp {{ number_format($transaksi->total) }}</span>
        </div>
        <div class="info-box">
            <b>Status</b>
            <span class="status {{ $transaksi->status }}">{{ ucfirst($transaksi->status) }}</span>
        </div>
    </div>

    <div class="title" style="font-size:20px;">Detail Produk</div>

    @forelse($detail as $item)
        <div class="item">
            @php $gambar = $item->produk->gambar ?? null; @endphp
            @if($gambar)
                <img src="{{ asset('uploads/'.basename($gambar)) }}">
            @else
                <img src="{{ asset('uploads/no-image.png') }}">
            @endif

            <div class="item-info">
                <b>{{ $item->produk->nama ?? 'Produk tidak ditemukan' }}</b><br>
                Qty: {{ $item->qty }}<br>
                Harga: Rp {{ number_format($item->subtotal / ($item->qty ?: 1)) }}
            </div>
        </div>
    @empty
        <p>Tidak ada detail produk</p>
    @endforelse

    <div>
        @if($transaksi->status == 'dikirim')
            <form action="{{ route('petugas.pesanan.selesai',$transaksi->id) }}" method="POST" style="display:inline;">
                @csrf
                <button class="btn">Tandai Selesai</button>
            </form>
        @endif
        <a href="{{ route('petugas.pesanan.index') }}" class="btn-back">Kembali</a>
    </div>

</div>

</div>

</body>
</html>