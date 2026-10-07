<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pesanan Saya - SnackinAja</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --coklat: #A65510; --krem: #FFFDE9; --krem-kartu: #F9F4D6; --gelap: #3A230F; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Poppins', sans-serif; background: var(--krem); color: var(--coklat); }

        .wadah { max-width: 900px; margin: 0 auto; padding: 30px 20px 60px; }
        h1 { color: var(--gelap); font-size: 26px; margin-bottom: 20px; }

        .pesanan { background: var(--krem-kartu); border-radius: 16px; padding: 22px 28px; margin-bottom: 16px; }
        .atas { display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; margin-bottom: 10px; }
        .nomor { color: var(--gelap); font-weight: 700; }
        .tanggal { font-size: 13px; }
        .status { background: var(--coklat); color: #fff; border-radius: 20px; padding: 4px 16px; font-size: 13px; font-weight: 600; }
        .status.dibatalkan { background: #A3342E; }
        .status.dibayar { background: #4C8C2B; }
        .isi { font-size: 15px; margin-bottom: 14px; }
        .bawah { display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; border-top: 2px solid var(--coklat); padding-top: 14px; }
        .total { font-weight: 700; font-size: 17px; }
        .metode { font-size: 13px; font-weight: 400; }
        .detail { border: 2px solid var(--coklat); border-radius: 10px; padding: 8px 18px; color: var(--coklat); font-weight: 600; text-decoration: none; }
        .detail:hover { background: var(--coklat); color: #fff; }

        .kosong { background: var(--krem-kartu); border-radius: 16px; text-align: center; padding: 50px 20px; }
        .kosong p { margin-bottom: 16px; }
        .kosong a { color: var(--coklat); font-weight: 600; }
        :focus-visible { outline: 3px solid var(--gelap); outline-offset: 2px; }
    </style>
</head>
<body>
    @include('partials.header', ['jumlahItem' => $jumlahItem])

    <div class="wadah">
        <h1>Pesanan Saya</h1>

        @forelse ($daftar as $pesanan)
            @php($items = $pesanan->items)
            <div class="pesanan">
                <div class="atas">
                    <div>
                        <div class="nomor">Pesanan #{{ $pesanan->id }}</div>
                        <div class="tanggal">{{ $pesanan->created_at->timezone('Asia/Jakarta')->locale('id')->translatedFormat('j F Y, H.i') }} WIB</div>
                    </div>
                    <span class="status {{ $pesanan->status }}">{{ $pesanan->label_status }}</span>
                </div>

                <div class="isi">
                    {{ $items[0]['nama'] ?? '-' }}@if (count($items) > 1) dan {{ count($items) - 1 }} produk lainnya @endif
                </div>

                <div class="bawah">
                    <div class="total">
                        Rp {{ number_format($pesanan->total_tagihan, 0, ',', '.') }}
                        <span class="metode">&middot; {{ $pesanan->metode }}</span>
                    </div>
                    <a href="{{ route('checkout.status', $pesanan->id) }}" class="detail">Lihat detail</a>
                </div>
            </div>
        @empty
            <div class="kosong">
                <p>Belum ada pesanan.</p>
                <a href="/">Mulai belanja</a>
            </div>
        @endforelse
    </div>
</body>
</html>
