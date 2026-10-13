<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Keranjang - SnackinAja</title>
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
        button { font-family: inherit; }

        /* Isi */
        .wadah { max-width: 1100px; margin: 0 auto; padding: 30px 20px 60px; }
        h1 { color: var(--gelap); font-size: 26px; margin-bottom: 20px; }
        .kembali { display: inline-flex; align-items: center; gap: 6px; margin-bottom: 16px; padding: 8px 16px; border: 2px solid var(--coklat); border-radius: 10px; background: var(--krem-kartu); color: var(--coklat); font-size: 14px; font-weight: 600; text-decoration: none; }
        .kembali:hover { background: var(--krem-input); }
        .isi { display: grid; grid-template-columns: 1.6fr 1fr; gap: 30px; align-items: start; }

        .bar-pilih { background: var(--krem-kartu); border-radius: 12px; padding: 14px 30px; margin-bottom: 20px; }
        .bar-pilih label { display: flex; align-items: center; gap: 12px; font-weight: 700; font-size: 14px; cursor: pointer; }
        input[type=checkbox] { width: 20px; height: 20px; accent-color: var(--coklat); cursor: pointer; flex-shrink: 0; }

        .daftar { background: var(--krem-kartu); border-radius: 12px; padding: 10px 30px; }
        .item { display: flex; flex-wrap: wrap; gap: 20px; align-items: center; padding: 22px 0; border-bottom: 2px solid var(--coklat); }
        .item:last-child { border-bottom: none; }
        .foto { width: 90px; height: 90px; border: 2px solid var(--coklat); border-radius: 12px; display: flex; align-items: center; justify-content: center; text-align: center; font-weight: 600; font-size: 14px; flex-shrink: 0; }
        .info { flex: 1; min-width: 140px; }
        .info .nama { color: var(--coklat); }
        .info .harga { font-weight: 600; margin-top: 4px; }
        .hapus { border: none; background: transparent; cursor: pointer; display: flex; padding: 4px; border-radius: 8px; }
        .hapus:hover { background: var(--krem-input); }
        .stepper { display: flex; align-items: center; border: 2px solid var(--coklat); border-radius: 20px; }
        .stepper button { border: none; background: transparent; color: var(--coklat); width: 34px; height: 30px; font-size: 20px; line-height: 1; cursor: pointer; border-radius: 20px; }
        .stepper button:hover:not(:disabled) { background: var(--krem-input); }
        .stepper button:disabled { opacity: .35; cursor: not-allowed; }
        .stepper span { min-width: 26px; text-align: center; font-size: 14px; }

        .catatan { flex-basis: calc(100% - 150px); margin-left: 150px; font-size: 14px; }
        .catatan summary { cursor: pointer; font-weight: 400; }
        .catatan textarea { width: 100%; margin-top: 8px; border: 2px solid var(--coklat); border-radius: 10px; background: var(--krem-input); padding: 10px 14px; font-family: inherit; font-size: 14px; color: var(--gelap); resize: vertical; }
        .catatan textarea::placeholder { color: var(--coklat); opacity: .7; }
        .error { color: #A3342E; font-size: 13px; margin-top: 4px; }

        .kosong { text-align: center; padding: 50px 20px; }
        .kosong p { margin-bottom: 18px; }
        .tombol-kosong { border: 2px solid var(--coklat); background: transparent; color: var(--coklat); border-radius: 10px; padding: 10px 20px; font-weight: 600; cursor: pointer; }

        /* Ringkasan */
        .panel { background: var(--krem-kartu); border-radius: 28px; padding: 30px; }
        .panel h2 { font-size: 18px; margin-bottom: 16px; }
        .baris { display: flex; justify-content: space-between; font-size: 17px; margin-bottom: 20px; }
        .baris strong { font-weight: 700; }
        .baris.kecil { font-size: 15px; margin-bottom: 10px; }
        .baris.total { margin: 0 0 20px; }
        .promo-baris { display: flex; gap: 10px; }
        .promo-baris input[type=text] { flex: 1; min-width: 0; border: 2px solid var(--coklat); border-radius: 10px; background: var(--krem-input); padding: 12px 16px; font-family: inherit; font-size: 14px; color: var(--gelap); }
        .promo-baris input[type=text]::placeholder { color: var(--coklat); opacity: .7; }
        .tombol-terapkan { border: 2px solid var(--coklat); background: var(--coklat); color: #fff; border-radius: 10px; padding: 0 20px; font-weight: 600; cursor: pointer; }
        .tombol-terapkan:hover { opacity: .9; }
        .promo-aktif { display: flex; justify-content: space-between; align-items: center; border: 2px solid #4C8C2B; border-radius: 10px; background: #E3F4D8; padding: 12px 16px; font-size: 14px; color: #2E6B1A; margin-bottom: 16px; }
        .promo-aktif button { border: none; background: transparent; color: #2E6B1A; text-decoration: underline; cursor: pointer; font-size: 13px; }
        .pesan-promo { font-size: 13px; margin-bottom: 10px; padding: 8px 14px; border-radius: 8px; }
        .pesan-promo.sukses { background: #E3F4D8; color: #2E6B1A; }
        .pesan-promo.gagal { background: #F8D7D7; color: #A3342E; }
        /* tombol bawaan tak terlihat: kalau Enter ditekan di kolom promo tanpa JS, yang jalan hanya "simpan", bukan hapus produk */
        .tombol-bawaan { position: absolute; left: -9999px; width: 1px; height: 1px; overflow: hidden; }
        hr { border: none; border-top: 1px solid var(--coklat); margin: 20px 0; }
        .tombol-checkout { width: 100%; background: var(--coklat); color: #fff; border: none; border-radius: 10px; padding: 14px; font-size: 18px; font-weight: 700; cursor: pointer; }
        .tombol-checkout:hover:not(:disabled) { opacity: .9; }
        .tombol-checkout:disabled { opacity: .45; cursor: not-allowed; }
        .pesan-error { background: #F8D7D7; color: #A3342E; border-radius: 10px; padding: 12px 18px; margin-bottom: 20px; font-weight: 600; font-size: 14px; }

        :focus-visible { outline: 3px solid var(--gelap); outline-offset: 2px; }

        @media (max-width: 860px) {
            .isi { grid-template-columns: 1fr; }
            .daftar { padding: 6px 18px; }
            .catatan { margin-left: 0; flex-basis: 100%; }
        }
    </style>
</head>
<body>
    @include('partials.header', ['jumlahItem' => count($items)])

    <div class="wadah">
        <a href="{{ url('/') }}" class="kembali">← Kembali ke menu</a>

        <h1>Keranjang</h1>

        @if (session('pesan_error'))
            <div class="pesan-error">{{ session('pesan_error') }}</div>
        @endif

        @if (count($items) === 0)
            <div class="daftar kosong">
                <p>Keranjangmu masih kosong.</p>
                <a href="/" class="tombol-kosong" style="display: inline-block; text-decoration: none;">Lihat menu jajanan</a>
            </div>
        @else
            {{-- Satu form untuk semua tombol, jadi centang & catatan selalu ikut tersimpan --}}
            <form method="POST" action="{{ route('keranjang.perbarui') }}" id="form-keranjang">
                @csrf
                <button type="submit" name="aksi" value="simpan" class="tombol-bawaan" tabindex="-1" aria-hidden="true">Simpan</button>
                <div class="isi">
                    <div>
                        <div class="bar-pilih">
                            <label>
                                <input type="checkbox" id="pilih-semua" @checked(collect($items)->every(fn ($item) => $item['dipilih']))>
                                Pilih Semua
                            </label>
                        </div>

                        <div class="daftar">
                            @foreach ($items as $item)
                                @php($id = $item['id'])
                                <div class="item" id="item-{{ $id }}">
                                    <input type="checkbox" class="cek-item" name="dipilih[]" value="{{ $id }}"
                                        data-harga="{{ $item['harga'] }}" data-jumlah="{{ $item['jumlah'] }}"
                                        aria-label="Pilih {{ $item['nama'] }}" @checked($item['dipilih'])>

                                    <div class="foto">Foto<br>Produk</div>

                                    <div class="info">
                                        <div class="nama">{{ $item['nama'] }}</div>
                                        <div class="harga">Rp {{ number_format($item['harga'], 0, ',', '.') }}</div>
                                    </div>

                                    <button type="submit" name="aksi" value="hapus:{{ $id }}" class="hapus" aria-label="Hapus {{ $item['nama'] }} dari keranjang">
                                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#A65510" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 7h16M10 11v6M14 11v6M6 7l1 13h10l1-13M9 7V4h6v3"/></svg>
                                    </button>

                                    <div class="stepper">
                                        <button type="submit" name="aksi" value="kurang:{{ $id }}" aria-label="Kurangi jumlah" @disabled($item['jumlah'] <= 1)>&minus;</button>
                                        <span aria-live="polite">{{ $item['jumlah'] }}</span>
                                        <button type="submit" name="aksi" value="tambah:{{ $id }}" aria-label="Tambah jumlah" @disabled($item['jumlah'] >= 99)>+</button>
                                    </div>

                                    <details class="catatan" @if (old("catatan.$id", $item['catatan']) !== '' && old("catatan.$id", $item['catatan']) !== null) open @endif>
                                        <summary>Catatan untuk penjual (opsional)</summary>
                                        <textarea name="catatan[{{ $id }}]" rows="2" maxlength="150"
                                            placeholder="Contoh: jangan terlalu pedas, tolong dipisah plastiknya">{{ old("catatan.$id", $item['catatan']) }}</textarea>
                                        @error("catatan.$id")
                                            <div class="error">{{ $message }}</div>
                                        @enderror
                                    </details>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="panel" id="panel" @if ($promoAktif) data-tipe="{{ $promoAktif['tipe'] }}" data-nilai="{{ $promoAktif['nilai'] }}" @endif>
                        <h2>Ringkasan Belanja</h2>
                        <div class="baris">
                            <span>Subtotal (<span id="jumlah-barang">{{ $totalBarang }}</span> barang)</span>
                            <strong id="subtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
                        </div>

                        @if (session('promo_sukses'))
                            <div class="pesan-promo sukses">{{ session('promo_sukses') }}</div>
                        @endif
                        @if (session('promo_gagal'))
                            <div class="pesan-promo gagal">{{ session('promo_gagal') }}</div>
                        @endif

                        @if ($promoAktif)
                            <div class="promo-aktif">
                                <span>Kode <strong>{{ $promoAktif['kode'] }}</strong> dipakai</span>
                                <button type="submit" name="aksi" value="hapuspromo">Hapus</button>
                            </div>
                            <div class="baris kecil">
                                <span>Diskon</span>
                                <strong id="diskon">- Rp {{ number_format($totalDiskon, 0, ',', '.') }}</strong>
                            </div>
                        @else
                            <div class="promo-baris">
                                <input type="text" name="kode_promo" id="kode-promo" placeholder="Masukkan kode promo" maxlength="30" autocomplete="off" aria-label="Kode promo">
                                <button type="submit" name="aksi" value="promo" id="tombol-promo" class="tombol-terapkan">Terapkan</button>
                            </div>
                        @endif

                        <hr>
                        @if ($promoAktif)
                            <div class="baris total">
                                <strong>Total</strong>
                                <strong id="total">Rp {{ number_format($totalTagihan, 0, ',', '.') }}</strong>
                            </div>
                        @endif
                        <button type="submit" name="aksi" value="checkout" id="tombol-checkout" class="tombol-checkout" @disabled($totalBarang === 0)>Proses Checkout</button>
                    </div>
                </div>
            </form>
        @endif
    </div>

    <script>
        (function () {
            var form = document.getElementById('form-keranjang');
            if (!form) return;

            var semua = document.getElementById('pilih-semua');
            var cek = Array.prototype.slice.call(form.querySelectorAll('.cek-item'));
            var subtotal = document.getElementById('subtotal');
            var jumlahBarang = document.getElementById('jumlah-barang');
            var tombol = document.getElementById('tombol-checkout');
            var panel = document.getElementById('panel');
            var diskonEl = document.getElementById('diskon');
            var totalEl = document.getElementById('total');
            var kodePromo = document.getElementById('kode-promo');

            function rp(n) { return 'Rp ' + n.toLocaleString('id-ID'); }

            // Subtotal ikut berubah langsung saat centang diubah, tanpa muat ulang halaman
            function hitung() {
                var total = 0, barang = 0;
                cek.forEach(function (c) {
                    if (c.checked) {
                        total += Number(c.dataset.harga) * Number(c.dataset.jumlah);
                        barang += Number(c.dataset.jumlah);
                    }
                });
                subtotal.textContent = rp(total);
                if (panel.dataset.tipe) {
                    var diskon = panel.dataset.tipe === 'persen'
                        ? Math.round(total * Number(panel.dataset.nilai) / 100)
                        : Math.min(Number(panel.dataset.nilai), total);
                    diskonEl.textContent = '- ' + rp(diskon);
                    totalEl.textContent = rp(total - diskon);
                }
                jumlahBarang.textContent = barang;
                tombol.disabled = barang === 0;
                semua.checked = cek.every(function (c) { return c.checked; });
            }

            semua.addEventListener('change', function () {
                cek.forEach(function (c) { c.checked = semua.checked; });
                hitung();
            });
            cek.forEach(function (c) { c.addEventListener('change', hitung); });

            // Enter di kolom promo = klik "Terapkan" (bukan tombol lain di form)
            if (kodePromo) {
                kodePromo.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        document.getElementById('tombol-promo').click();
                    }
                });
            }
            hitung();
        })();
    </script>
</body>
</html>