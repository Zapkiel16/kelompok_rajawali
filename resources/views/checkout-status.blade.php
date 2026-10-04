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
        .catatan-item { font-size: 13px; opacity: .85; margin: -4px 0 10px; }
        .bayar { margin-top: 30px; padding-top: 24px; border-top: 2px solid var(--coklat); }
        .bayar h2 { color: var(--gelap); font-size: 18px; margin-bottom: 8px; }
        .bayar p { font-size: 14px; }
        .nominal { font-size: 26px; font-weight: 700; color: var(--gelap); margin: 6px 0; }
        .qris { width: 240px; height: 240px; margin: 14px auto 0; display: block; object-fit: contain; background: #fff; border: 2px solid var(--coklat); border-radius: 14px; }
        .qris-kosong { display: flex; align-items: center; justify-content: center; padding: 16px; font-size: 13px; }
        .wadah > a { color: var(--coklat); display: inline-block; margin-top: 30px; }
    </style>
</head>
<body>
    @include('partials.header')
    <div class="wadah">
        <h1>Checkout Berhasil</h1>
        <p>Transaksi #{{ $transaksi->id }}</p>
        <div class="status">{{ $transaksi->label_status }}</div>

        <div class="detail">
            @foreach ($transaksi->items as $item)
                <div class="baris">
                    <span>{{ $item['nama'] }} x{{ $item['jumlah'] }}</span>
                    <span>Rp {{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}</span>
                </div>
                @if (!empty($item['catatan']))
                    <div class="catatan-item">Catatan: {{ $item['catatan'] }}</div>
                @endif
            @endforeach
            <hr>
            @if ($transaksi->nama_pemesan)
                <div class="baris"><span>Atas nama</span><span>{{ $transaksi->nama_pemesan }}</span></div>
            @endif
            <div class="baris"><span>Metode</span><span>{{ $transaksi->metode }}</span></div>
            <div class="baris"><strong>Total Tagihan</strong><strong>Rp {{ number_format($transaksi->total_tagihan, 0, ',', '.') }}</strong></div>
        </div>

        <div class="bayar">
            @if ($transaksi->metode === 'QRIS')
                <h2>Scan QRIS untuk membayar</h2>
                <p>Masukkan nominal sesuai total tagihan, lalu tunjukkan bukti bayar ke penjual.</p>
                <div class="nominal">Rp {{ number_format($transaksi->total_tagihan, 0, ',', '.') }}</div>
                @if (file_exists(public_path('images/qris.png')))
                    <img class="qris" src="{{ asset('images/qris.png') }}" alt="QRIS SnackinAja">
                @else
                    <div class="qris qris-kosong">Gambar QRIS belum dipasang. Simpan di public/images/qris.png</div>
                @endif
            @else
                <h2>Bayar tunai ke penjual</h2>
                <p>Siapkan uang pas sejumlah total tagihan, lalu bayar saat mengambil pesanan.</p>
                <div class="nominal">Rp {{ number_format($transaksi->total_tagihan, 0, ',', '.') }}</div>
            @endif
        </div>

        <a href="{{ route('pesanan.index') }}">Lihat semua pesanan</a>
    </div>
</body>
</html>