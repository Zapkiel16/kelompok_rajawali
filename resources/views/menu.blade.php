<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menu Jajanan - SnackinAja</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Poppins', sans-serif; background: #FFFDE9; color: #3A230F; }
        .wadah { max-width: 1100px; margin: 0 auto; padding: 36px 24px 60px; }
        h1 { font-size: 26px; margin-bottom: 6px; }
        .sub { margin-bottom: 24px; opacity: .8; }
        .sukses { background: #E3F4D8; color: #2E6B1A; border-radius: 10px; padding: 12px 18px; margin-bottom: 20px; font-weight: 600; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px; }
        .kartu { background: #fff; border: 2px solid #A65510; border-radius: 14px; overflow: hidden; display: flex; flex-direction: column; }
        .gambar { height: 140px; background: #F9F4D6; display: flex; align-items: center; justify-content: center; color: #A65510; font-weight: 600; font-size: 13px; }
        .isi { padding: 14px; display: flex; flex-direction: column; gap: 8px; flex: 1; }
        .nama { font-weight: 600; font-size: 15px; line-height: 1.35; flex: 1; }
        .harga { color: #A65510; font-weight: 700; }
        .tombol { width: 100%; background: #A65510; color: #fff; border: none; border-radius: 10px; padding: 10px; font-family: inherit; font-weight: 600; cursor: pointer; }
        .tombol:hover { opacity: .9; }
        .kosong { text-align: center; padding: 60px 0; opacity: .8; }
    </style>
</head>
<body>
    @include('partials.header', ['jumlahItem' => $jumlahItem])

    <div class="wadah">
        <h1>Menu Jajanan</h1>
        <p class="sub">
            @if ($q !== '')
                Hasil pencarian untuk "{{ $q }}"
            @else
                Pilih jajanan favoritmu, lalu masukkan ke keranjang
            @endif
        </p>

        @if (session('sukses'))
            <div class="sukses">{{ session('sukses') }}</div>
        @endif

        @if ($produk->isEmpty())
            <div class="kosong">
                <p>Jajanan yang kamu cari belum ada.</p>
                <p><a href="/">Lihat semua menu</a></p>
            </div>
        @else
            <div class="grid">
                @foreach ($produk as $p)
                    <div class="kartu">
                        <div class="gambar">GAMBAR</div>
                        <div class="isi">
                            <div class="nama">{{ $p['nama'] }}</div>
                            <div class="harga">Rp {{ number_format($p['harga'], 0, ',', '.') }}</div>
                            <form method="POST" action="{{ route('menu.tambah') }}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $p['id'] }}">
                                <button type="submit" class="tombol">Tambah ke keranjang</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>