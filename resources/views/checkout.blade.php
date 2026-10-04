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
        h1 { color: var(--gelap); font-size: 26px; margin-bottom: 6px; }
        .kembali { display: inline-block; margin-bottom: 20px; color: var(--coklat); font-size: 14px; }
        .isi { display: grid; grid-template-columns: 1.6fr 1fr; gap: 30px; align-items: start; }

        .daftar { background: var(--krem-kartu); border-radius: 12px; padding: 10px 30px; }
        .item { display: flex; flex-wrap: wrap; gap: 20px; align-items: center; padding: 20px 0; border-bottom: 2px solid var(--coklat); }
        .item:last-child { border-bottom: none; }
        .foto { width: 90px; height: 90px; border: 2px solid var(--coklat); border-radius: 12px; display: flex; align-items: center; justify-content: center; text-align: center; font-weight: 600; font-size: 14px; flex-shrink: 0; }
        .info { flex: 1; }
        .info .harga { font-weight: 600; margin-top: 4px; }
        .jumlah { align-self: flex-end; }

        .catatan { flex-basis: 100%; font-size: 14px; }
        .catatan summary { cursor: pointer; font-weight: 400; }
        .catatan textarea { width: 100%; margin-top: 8px; border: 2px solid var(--coklat); border-radius: 10px; background: var(--krem-input); padding: 10px 14px; font-family: inherit; font-size: 14px; color: var(--gelap); resize: vertical; }
        .catatan textarea::placeholder { color: var(--coklat); opacity: .7; }
        .catatan .error { color: #A3342E; font-size: 13px; margin-top: 4px; }

        .panel { background: var(--krem-kartu); border-radius: 28px; padding: 30px; }
        .panel h2 { font-size: 18px; margin-bottom: 10px; }
        .metode { display: grid; grid-template-columns: 1fr 1fr; gap: 6px; margin-bottom: 20px; }
        .metode input { display: none; }
        .metode label { display: block; width: 100%; text-align: center; padding: 10px 10px; border: 2px solid var(--coklat); border-radius: 10px; background: var(--krem-input); font-weight: 600; cursor: pointer; }
        .metode input:checked + label { background: var(--coklat); color: #fff; }

        .promo-baris { display: flex; gap: 10px; margin-bottom: 10px; }
        .promo-baris input[type=text] { flex: 1; border: 2px solid var(--coklat); border-radius: 10px; background: var(--krem-input); padding: 12px 16px; font-family: inherit; font-size: 14px; color: var(--gelap); }
        .promo-baris input[type=text]::placeholder { color: var(--coklat); opacity: .7; }
        .tombol-terapkan { border: 2px solid var(--coklat); background: var(--coklat); color: #fff; border-radius: 10px; padding: 0 20px; font-family: inherit; font-weight: 600; cursor: pointer; }
        .tombol-terapkan:hover { opacity: .9; }

        .promo-aktif { display: flex; justify-content: space-between; align-items: center; border: 2px solid #4C8C2B; border-radius: 10px; background: #E3F4D8; padding: 12px 16px; font-size: 14px; color: #2E6B1A; margin-bottom: 10px; }
        .promo-aktif button { border: none; background: transparent; color: #2E6B1A; text-decoration: underline; cursor: pointer; font-family: inherit; font-size: 13px; }

        .pesan-promo { font-size: 13px; margin-bottom: 10px; padding: 8px 14px; border-radius: 8px; }
        .pesan-promo.sukses { background: #E3F4D8; color: #2E6B1A; }
        .pesan-promo.gagal { background: #F8D7D7; color: #A3342E; }

        hr { border: none; border-top: 1px solid var(--coklat); margin: 16px 0; }
        .baris { display: flex; justify-content: space-between; margin: 16px 0; font-size: 17px; }
        .tombol-checkout { width: 100%; background: var(--coklat); color: #fff; border: none; border-radius: 10px; padding: 14px; font-family: inherit; font-size: 18px; font-weight: 700; cursor: pointer; margin-top: 24px; }
        .tombol-checkout:hover { opacity: .9; }
        .sukses { background: #E3F4D8; color: #2E6B1A; border-radius: 10px; padding: 12px 18px; margin-bottom: 20px; font-weight: 600; }
    </style>
</head>
<body>
      @include('partials.header')

    <div class="wadah">
        <h1>Checkout</h1>
        <a href="{{ route('keranjang.index') }}" class="kembali">&larr; Kembali ke keranjang</a>

        @if (session('sukses'))
            <div class="sukses">{{ session('sukses') }}</div>
        @endif

        <div class="isi">
            <div class="daftar">
                @foreach ($items as $item)
                    @php($i = $item['id'])
                    <div class="item">
                        <div class="foto">Foto<br>Produk</div>
                        <div class="info">
                            <div>{{ $item['nama'] }}</div>
                            <div class="harga">Rp {{ number_format($item['harga'], 0, ',', '.') }}</div>
                        </div>
                        <div class="jumlah">{{ $item['jumlah'] }}x</div>

                        <details class="catatan" @if (old("catatan.$i", $item['catatan']) !== '' && old("catatan.$i", $item['catatan']) !== null) open @endif>
                            <summary>Catatan untuk penjual (opsional)</summary>
                            <textarea name="catatan[{{ $i }}]" form="form-pembayaran" rows="2" maxlength="150"
                                placeholder="Contoh: jangan terlalu pedas, tolong dipisah plastiknya">{{ old("catatan.$i", $item['catatan']) }}</textarea>
                            @error("catatan.$i")
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </details>
                    </div>
                @endforeach
            </div>

            <div class="panel">
                <h2>Metode Pembayaran</h2>
                <form method="POST" action="{{ route('checkout.proses') }}" id="form-pembayaran">
                    @csrf
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
                </form>

                @if (session('promo_sukses'))
                    <div class="pesan-promo sukses">{{ session('promo_sukses') }}</div>
                @endif
                @if (session('promo_gagal'))
                    <div class="pesan-promo gagal">{{ session('promo_gagal') }}</div>
                @endif

                @if ($kodePromoAktif)
                    <div class="promo-aktif">
                        <span>Promo "{{ $kodePromoAktif }}" aktif</span>
                        <form method="POST" action="{{ route('checkout.promo.hapus') }}" class="sinkron-catatan">
                            @csrf
                            <button type="submit">Hapus</button>
                        </form>
                    </div>
                @else
                    <form method="POST" action="{{ route('checkout.promo') }}" class="promo-baris sinkron-catatan">
                        @csrf
                        <input type="text" name="kode_promo" placeholder="Masukkan kode promo">
                        <button type="submit" class="tombol-terapkan">Terapkan</button>
                    </form>
                @endif

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

                <button type="submit" form="form-pembayaran" class="tombol-checkout">Checkout</button>
            </div>
        </div>
    </div>

    <script>
        // Form promo ikut membawa isi catatan, supaya tidak hilang saat halaman dimuat ulang
        document.querySelectorAll('form.sinkron-catatan').forEach(function (form) {
            form.addEventListener('submit', function () {
                document.querySelectorAll('textarea[name^="catatan["]').forEach(function (ta) {
                    var h = document.createElement('input');
                    h.type = 'hidden';
                    h.name = ta.name;
                    h.value = ta.value;
                    form.appendChild(h);
                });
            });
        });
    </script>
</body>
</html>