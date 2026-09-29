<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout - SnackinAja</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --coklat: #A65510;
            --krem: #FFFDE9;
            --krem-kartu: #F9F4D6;
            --krem-input: #EBE8C8;
            --gelap: #3A230F;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Poppins', sans-serif; background: var(--krem); color: var(--coklat); }

        .header { background: var(--coklat); height: 70px; padding: 0 60px; display: flex; align-items: center; justify-content: space-between; }
        .logo { color: #FFD9C7; font-weight: 700; font-size: 22px; }
        .tombol-akun { border: 2px solid #fff; color: #fff; background: transparent; border-radius: 10px; padding: 8px 18px; font-family: inherit; font-weight: 600; }

        .wadah { max-width: 1100px; margin: 0 auto; padding: 30px 20px; }
        h1 { color: var(--gelap); font-size: 26px; margin-bottom: 20px; }
        .isi { display: grid; grid-template-columns: 1.6fr 1fr; gap: 30px; align-items: start; }

        .daftar { background: var(--krem-kartu); border-radius: 12px; padding: 10px 30px; }
        .item { display: flex; gap: 20px; align-items: center; padding: 20px 0; border-bottom: 2px solid var(--coklat); }
        .item:last-child { border-bottom: none; }
        .foto { width: 90px; height: 90px; border: 2px solid var(--coklat); border-radius: 12px; display: flex; align-items: center; justify-content: center; text-align: center; font-weight: 600; font-size: 14px; flex-shrink: 0; }
        .info { flex: 1; }
        .info .harga { font-weight: 600; margin-top: 4px; }
        .jumlah { align-self: flex-end; }

        .panel { background: var(--krem-kartu); border-radius: 28px; padding: 30px; }
        .panel h2 { font-size: 18px; margin-bottom: 20px; }
        .metode { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 26px; }
        .metode input { display: none; }
        .metode label { text-align: center; padding: 10px; border: 2px solid var(--coklat); border-radius: 10px; background: var(--krem-input); font-weight: 600; cursor: pointer; }
        .metode input:checked + label { background: var(--coklat); color: #fff; }

        .promo { border: 2px solid var(--coklat); border-radius: 10px; background: var(--krem-input); padding: 14px 20px; font-size: 14px; margin-bottom: 20px; }
        hr { border: none; border-top: 1px solid var(--coklat); margin: 10px 0; }
        .baris { display: flex; justify-content: space-between; margin: 16px 0; font-size: 17px; }
        .tombol-checkout { width: 100%; background: var(--coklat); color: #fff; border: none; border-radius: 10px; padding: 14px; font-family: inherit; font-size: 18px; font-weight: 700; cursor: pointer; margin-top: 10px; }
        .tombol-checkout:hover { opacity: .9; }
        .sukses { background: #E3F4D8; color: #2E6B1A; border-radius: 10px; padding: 12px 18px; margin-bottom: 20px; font-weight: 600; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">SnackinAja</div>
        <button class="tombol-akun" type="button">Aku Ganteng</button>
    </div>

    <div class="wadah">
        <h1>Checkout</h1>

        @if (session('sukses'))
            <div class="sukses">{{ session('sukses') }}</div>
        @endif

        <div class="isi">
            <div class="daftar">
                @foreach ($items as $item)
                    <div class="item">
                        <div class="foto">Foto<br>Produk</div>
                        <div class="info">
                            <div>{{ $item['nama'] }}</div>
                            <div class="harga">Rp {{ number_format($item['harga'], 0, ',', '.') }}</div>
                        </div>
                        <div class="jumlah">{{ $item['jumlah'] }}x</div>
                    </div>
                @endforeach
            </div>

            <form class="panel" method="POST" action="{{ route('checkout.proses') }}">
                @csrf
                <h2>Metode Pembayaran</h2>
                <div class="metode">
                    <div>
                        <input type="radio" name="metode" id="qris" value="QRIS" checked>
                        <label for="qris">QRIS</label>
                    </div>
                    <div>
                        <input type="radio" name="metode" id="cash" value="Cash">
                        <label for="cash">Cash</label>
                    </div>
                </div>

                <div class="promo">Lagi belum ada promo nih</div>
                <hr>

                <h2>Cek Total Belanja</h2>
                <div class="baris">
                    <span>Total Harga ({{ $totalBarang }} Barang)</span>
                    <span>Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                </div>
                <div class="baris">
                    <span>Total Diskon</span>
                    <span>Rp {{ number_format($totalDiskon, 0, ',', '.') }}</span>
                </div>
                <hr>
                <div class="baris">
                    <span>Total Tagihan</span>
                    <span>Rp {{ number_format($totalTagihan, 0, ',', '.') }}</span>
                </div>

                <button type="submit" class="tombol-checkout">Checkout</button>
            </form>
        </div>
    </div>
</body>
</html>