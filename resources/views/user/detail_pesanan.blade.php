<!DOCTYPE html>
<html>
<head>
    <title>Detail Pesanan</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        *{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
        body{background:#dfe7f2;}
        header{background:#8FAFD6;padding:15px 60px;display:flex;justify-content:space-between;align-items:center;}
        .logo{display:flex;align-items:center;gap:10px;}
        .logo img{width:45px;}
        .icons{font-size:22px;}
        .icons a{text-decoration:none;color:black;margin-left:10px;}
        .container{padding:40px 80px;}
        .back-btn{display:inline-block;background:#eee;padding:10px 20px;border-radius:10px;text-decoration:none;color:black;margin-bottom:20px;}
        .grid{display:grid;grid-template-columns:2fr 1fr;gap:30px;}
        .card{background:white;border-radius:10px;box-shadow:0 5px 15px rgba(0,0,0,0.1);overflow:hidden;}
        .order-head{padding:15px 20px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid #ddd;}
        .status{background:#555;color:white;padding:5px 15px;border-radius:6px;font-size:14px;}
        .item{display:flex;align-items:center;gap:15px;padding:15px 20px;border-bottom:1px solid #eee;}
        .item img{width:70px;background:#f3f3f3;padding:8px;border-radius:8px;}
        .item-name{flex:1;}
        .item-price{font-weight:600;}
        .total{padding:15px 20px;text-align:right;font-weight:600;}
        .info-box{background:white;padding:20px;border-radius:10px;box-shadow:0 5px 15px rgba(0,0,0,0.1);margin-bottom:20px;}
        .info-box h3{margin-bottom:15px;}
        .row{display:flex;justify-content:space-between;margin-bottom:10px;}
        .btn{display:inline-block;padding:6px 14px;border-radius:8px;border:none;font-size:13px;color:white;cursor:pointer;text-decoration:none;margin-top:8px;}
        .pay-btn{background:#3b5bdb;}
        .flash-message{color:green;margin-bottom:15px;}

        /* TRACKING */
        .tracking-box{
            margin-top:40px;
            background:white;
            padding:25px;
            border-radius:10px;
            box-shadow:0 5px 15px rgba(0,0,0,0.1);
        }

        .tracking{
            display:flex;
            justify-content:space-between;
            position:relative;
        }

        .tracking::before{
            content:'';
            position:absolute;
            top:18px;
            left:0;
            right:0;
            height:4px;
            background:#ddd;
            z-index:0;
        }

        .step{
            text-align:center;
            width:100%;
            position:relative;
            z-index:1;
        }

        .circle{
            width:35px;
            height:35px;
            border-radius:50%;
            background:#ccc;
            color:white;
            display:flex;
            align-items:center;
            justify-content:center;
            margin:0 auto 10px;
            font-weight:bold;
        }

        .step.active .circle{background:#3b5bdb;}
        .step.done .circle{background:#28a745;}

        .text b{font-size:14px;}
        .text p{font-size:12px;color:#666;}

        /* ⭐ RATING (TAMBAHAN) */
        .rating{display:flex;gap:5px;margin-top:10px;}
        .star{font-size:20px;cursor:pointer;color:#ccc;}
        .star.active{color:gold;}
    </style>
</head>
<body>

<header>
    <div class="logo">
        <img src="{{ asset('uploads/assets/blue 2.png') }}">
        <b>KioStore</b>
    </div>

    <div class="icons">
        <a href="{{ route('keranjang') }}">🛒</a>
        <a href="{{ route('user.profile') }}">👤</a>
    </div>
</header>

<div class="container">

    <a href="{{ route('user.riwayat') }}" class="back-btn">⬅ Kembali</a>

    <h2>Detail Pesanan</h2>
    <br>

    @if(session('success'))
        <div class="flash-message">
            {{ session('success') }}
        </div>
    @endif

    @php
        $displayStatus = $transaksi->status;

        if($transaksi->metode == 'cod' && $transaksi->status == 'pending'){
            $displayStatus = 'diproses';
        }

        $isCOD = $transaksi->metode == 'cod';
    @endphp

    <div class="grid">

        <!-- LEFT -->
        <div class="card">
            <div class="order-head">
                <div>
                    <b>#{{ $transaksi->id }}</b><br>
                    Tanggal pesanan :
                    {{ \Carbon\Carbon::parse($transaksi->tanggal)->translatedFormat('d F Y') }}<br>
                    Metode Pembayaran :
                    <b>
                        @if($isCOD)
                            COD (Bayar di Tempat)
                        @else
                            Transfer Bank
                        @endif
                    </b>
                    <br>
                    Tiba pada :
                    {{ \Carbon\Carbon::parse($transaksi->tanggal)->addDays(3)->translatedFormat('d F Y') }}
                </div>

                <div class="status">
                    {{ ucfirst($displayStatus) }}
                </div>
            </div>

            @php $total = 0; @endphp
            @foreach($detail as $item)
                @php $total += $item->subtotal; @endphp

                <div class="item">
                    <img src="{{ asset('uploads/'.$item->gambar) }}">

                    <div class="item-name">
                        {{ $item->nama }} x{{ $item->qty }}

                        {{-- ⭐ RATING MUNCUL SAAT SELESAI --}}
                        @if($displayStatus == 'selesai')

                            @if(isset($ulasan) && $ulasan->has($item->produk_id))
                                <p style="color:green;margin-top:10px;font-weight:bold;">
                                    ✔ Rating sudah dikirim
                                </p>
                            @else
                                <form action="{{ route('rating.store') }}" method="POST" onsubmit="return validateRating(this)">
                                    @csrf
                                    <input type="hidden" name="produk_id" value="{{ $item->produk_id }}">
                                    <input type="hidden" name="rating" class="rating-value">

                                    <div class="rating">
                                        @for($i=1; $i<=5; $i++)
                                            <span class="star" onclick="setRating(this, {{ $i }})">★</span>
                                        @endfor
                                    </div>

                                    <button type="submit" class="btn" style="background:#f59e0b;margin-top:10px;">
                                        Kirim Rating
                                    </button>
                                </form>
                            @endif

                        @endif
                    </div>

                    <div class="item-price">Rp {{ number_format($item->subtotal) }}</div>
                </div>
            @endforeach

            <div class="total">Total : Rp {{ number_format($total) }}</div>
        </div>

        <!-- RIGHT -->
        <div>
            <div class="info-box">
                <h3>Informasi Pembayaran</h3>

                <div class="row">
                    <span>Total Produk</span>
                    <span>Rp {{ number_format($total) }}</span>
                </div>

                <div class="row">
                    <span>Ongkos Kirim</span>
                    <span>Rp 10.000</span>
                </div>

                <hr><br>

                <div class="row">
                    <b>Total</b>
                    <b>Rp {{ number_format($total+10000) }}</b>
                </div>
            </div>

            <div class="info-box">
                <h3>Alamat Pengiriman</h3>
                <p>{{ $transaksi->alamat ?? auth()->user()->alamat }}</p>
            </div>

            @if(!$isCOD && $transaksi->status == 'pending')
                <a href="{{ route('pembayaran', $transaksi->id) }}" class="btn pay-btn">Lanjut ke Pembayaran</a>
            @endif
        </div>

    </div>

    <!-- TRACKING -->
    <div class="tracking-box">
        <h3>Tracking Pesanan</h3>

        <div class="tracking">

            @if(!$isCOD)
                <div class="step {{ ($displayStatus == 'pending') ? 'active' : 'done' }}">
                    <div class="circle">1</div>
                    <div class="text">
                        <b>Menunggu Pembayaran</b>
                        <p>Menunggu user menuntaskan pembayaran</p>
                    </div>
                </div>

                <div class="step {{ ($displayStatus == 'diproses') ? 'active' : (in_array($displayStatus,['dikirim','selesai']) ? 'done' : '') }}">
                    <div class="circle">2</div>
                    <div class="text">
                        <b>Diproses</b>
                        <p>Dikemas, dikirim, di antar ke ekspedisi</p>
                    </div>
                </div>

                <div class="step {{ ($displayStatus == 'dikirim') ? 'active' : ($displayStatus == 'selesai' ? 'done' : '') }}">
                    <div class="circle">3</div>
                    <div class="text">
                        <b>Dikirim</b>
                        <p>Menuju alamat</p>
                    </div>
                </div>

                <div class="step {{ ($displayStatus == 'selesai') ? 'active done' : '' }}">
                    <div class="circle">4</div>
                    <div class="text">
                        <b>Selesai</b>
                        <p>Paket sudah terkirim dan sampai ke tertuju</p>
                    </div>
                </div>

            @else
                <div class="step {{ ($displayStatus == 'diproses') ? 'active' : (in_array($displayStatus,['dikirim','selesai']) ? 'done' : '') }}">
                    <div class="circle">1</div>
                    <div class="text">
                        <b>Diproses</b>
                        <p>Dikemas, dikirim, di antar ke ekspedisi</p>
                    </div>
                </div>

                <div class="step {{ ($displayStatus == 'dikirim') ? 'active' : ($displayStatus == 'selesai' ? 'done' : '') }}">
                    <div class="circle">2</div>
                    <div class="text">
                        <b>Dikirim</b>
                        <p>Menuju alamat</p>
                    </div>
                </div>

                <div class="step {{ ($displayStatus == 'selesai') ? 'active done' : '' }}">
                    <div class="circle">3</div>
                    <div class="text">
                        <b>Selesai</b>
                        <p>Paket sudah terkirim dan sampai ke tertuju</p>
                    </div>
                </div>
            @endif

        </div>
    </div>

</div>

{{-- ⭐ JS RATING --}}
<script>
function setRating(el, value){
    let stars = el.parentElement.querySelectorAll('.star');
    let input = el.closest('form').querySelector('.rating-value');

    input.value = value;

    stars.forEach((s, i)=>{
        s.classList.toggle('active', i < value);
    });
}

function validateRating(form){
    let rating = form.querySelector('.rating-value').value;
    if(!rating){
        alert("Silakan pilih rating dulu!");
        return false;
    }
    return true;
}
</script>

</body>
</html>