<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Status Transaksi - SnackinAja</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --coklat: #A65510; --krem: #FFFDE9; --krem-kartu: #F9F4D6; --gelap: #3A230F; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Poppins', sans-serif; background: var(--krem); color: var(--coklat); }
        .header { background: var(--coklat); height: 70px; padding: 0 60px; display: flex; align-items: center; }
        .logo { color: #FFD9C7; font-weight: 700; font-size: 22px; }
        .wadah { max-width: 600px; margin: 60px auto; background: var(--krem-kartu); border-radius: 20px; padding: 40px; text-align: center; }
        h1 { color: var(--gelap); margin-bottom: 10px; }
        .status { display: inline-block; margin-top: 10px; padding: 6px 18px; border-radius: 20px; background: var(--coklat); color: #fff; font-weight: 600; }
        .detail { text-align: left; margin-top: 30px; }
        .baris { display: flex; justify-content: space-between; margin: 8px 0; }
        a { color: var(--coklat); display: inline-block; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="header"><div class="logo">SnackinAja</div></div>
    <div class="wadah">
        <h1>Checkout Berhasil</h1>
        <p>Transaksi #{{ $transaksi->id }}</p>
        <div class="status">{{ ucfirst($transaksi->status) }}</div>

        <div class="detail">
            @foreach ($transaksi->items as $item)
                <div class="baris">
                    <span>{{ $item['nama'] }} x{{ $item['jumlah'] }}</span>
                    <span>Rp {{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}</span>
                </div>
            @endforeach
            <hr>
            <div class="baris"><span>Metode</span><span>{{ $transaksi->metode }}</span></div>
            <div class="baris"><strong>Total Tagihan</strong><strong>Rp {{ number_format($transaksi->total_tagihan, 0, ',', '.') }}</strong></div>
        </div>

        <a href="{{ route('checkout.index') }}">Kembali ke Checkout</a>
    </div>
</body>
</html>