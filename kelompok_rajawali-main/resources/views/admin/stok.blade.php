<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Stok - SnackinAja Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --coklat: #A65510; --krem: #FFFDE9; --krem-kartu: #F9F4D6; --gelap: #3A230F; --merah: #A3342E; --hijau: #4C8C2B; --oranye: #C77A12; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Poppins', sans-serif; background: var(--krem); color: var(--coklat); }

        .bar { background: var(--coklat); height: 70px; padding: 0 60px; display: flex; align-items: center; gap: 24px; }
        .bar .logo { color: #FFD9C7; font-weight: 700; font-size: 22px; text-decoration: none; margin-right: auto; }
        .bar .logo span { background: #FFD9C7; color: var(--coklat); border-radius: 8px; padding: 2px 10px; font-size: 13px; margin-left: 8px; vertical-align: middle; }
        .bar a.tautan { color: #fff; font-weight: 600; text-decoration: none; border: 2px solid #fff; border-radius: 10px; padding: 8px 18px; white-space: nowrap; }
        .bar a.tautan:hover { background: #fff; color: var(--coklat); }

        .wadah { max-width: 1000px; margin: 0 auto; padding: 30px 20px 60px; }
        h1 { color: var(--gelap); font-size: 26px; }
        .sapa { font-size: 14px; margin: 2px 0 22px; }

        .info-hijau { background: #E3F4D8; color: #2E6B1A; border-radius: 14px; padding: 12px 18px; margin-bottom: 20px; font-size: 14px; }

        .ringkasan { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 24px; }
        .kartu { background: var(--krem-kartu); border-radius: 16px; padding: 18px 22px; }
        .kartu .angka { color: var(--gelap); font-size: 28px; font-weight: 700; line-height: 1.2; }
        .kartu .label { font-size: 13px; }
        .kartu.menipis .angka { color: var(--oranye); }
        .kartu.habis .angka { color: var(--merah); }

        .tabel-wrap { background: var(--krem-kartu); border-radius: 16px; padding: 8px 22px; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; min-width: 640px; }
        th { text-align: left; font-size: 13px; font-weight: 600; padding: 14px 10px; border-bottom: 2px solid var(--coklat); }
        td { padding: 14px 10px; border-bottom: 1px solid #E3D9A8; vertical-align: middle; font-size: 15px; }
        tr:last-child td { border-bottom: none; }
        td.nama { color: var(--gelap); font-weight: 600; }
        td.nama small { display: block; font-weight: 400; font-size: 12px; color: var(--coklat); }

        .lencana { display: inline-block; border-radius: 20px; padding: 3px 14px; font-size: 12px; font-weight: 600; color: #fff; }
        .lencana.aman { background: var(--hijau); }
        .lencana.menipis { background: var(--oranye); }
        .lencana.habis { background: var(--merah); }

        .form-stok { display: flex; gap: 8px; align-items: center; }
        .form-stok input { width: 90px; border: 2px solid var(--coklat); border-radius: 10px; background: var(--krem); padding: 7px 10px; font-family: inherit; font-size: 15px; color: var(--gelap); }
        .form-stok button { background: var(--coklat); color: #fff; border: none; border-radius: 10px; padding: 8px 18px; font-family: inherit; font-size: 14px; font-weight: 600; cursor: pointer; }
        .form-stok button:hover { opacity: .9; }
        .error { color: var(--merah); font-size: 12px; margin-top: 4px; }

        :focus-visible { outline: 3px solid var(--gelap); outline-offset: 2px; }

        @media (max-width: 860px) {
            .bar { height: auto; min-height: 70px; padding: 10px 16px; gap: 8px; flex-wrap: wrap; }
            .bar .logo { font-size: 17px; }
            .bar .logo span { font-size: 11px; margin-left: 4px; padding: 2px 8px; }
            .bar a.tautan { padding: 6px 10px; font-size: 13px; }
            .ringkasan { grid-template-columns: repeat(2, 1fr); }

            /* Tabel jadi susunan kartu supaya kolom Stok tidak tergeser keluar layar */
            .tabel-wrap { padding: 4px 16px; }
            table { min-width: 0; }
            thead { display: none; }
            tr { display: block; padding: 12px 0; border-bottom: 1px solid #E3D9A8; }
            tr:last-child { border-bottom: none; }
            td { display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 4px 12px; border: none; padding: 5px 0; }
            td[data-label]::before { content: attr(data-label); font-size: 13px; font-weight: 600; }
            td.nama { font-size: 17px; }
            td.nama small { display: inline; margin-left: 8px; }
            .error { flex-basis: 100%; text-align: right; }
        }
    </style>
</head>
<body>
    <header class="bar">
        <a href="{{ route('admin.stok') }}" class="logo">SnackinAja<span>Admin</span></a>
        <a href="{{ route('dashboard') }}" class="tautan">Lihat Toko</a>
        <a href="{{ route('logout.konfirmasi') }}" class="tautan">Keluar</a>
    </header>

    <main class="wadah">
        <h1>Kelola Stok</h1>
        <p class="sapa">Halo, {{ auth()->user()->name }}. Atur jumlah stok tiap produk di sini.</p>

        @if (session('sukses'))
            <div class="info-hijau" role="status">{{ session('sukses') }}</div>
        @endif

        <section class="ringkasan" aria-label="Ringkasan stok">
            <div class="kartu">
                <div class="angka">{{ $jumlahProduk }}</div>
                <div class="label">Jumlah produk</div>
            </div>
            <div class="kartu">
                <div class="angka">{{ number_format($totalStok, 0, ',', '.') }}</div>
                <div class="label">Total stok</div>
            </div>
            <div class="kartu menipis">
                <div class="angka">{{ $jumlahMenipis }}</div>
                <div class="label">Stok menipis (&le; {{ \App\Data\ProductCatalog::STOK_MENIPIS }})</div>
            </div>
            <div class="kartu habis">
                <div class="angka">{{ $jumlahHabis }}</div>
                <div class="label">Stok habis</div>
            </div>
        </section>

        <div class="tabel-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produk as $p)
                        @php
                            $bag = 'stok-'.$p['id'];
                            $adaError = $errors->hasBag($bag);
                            $nilai = $adaError ? old('stok', $p['stock']) : $p['stock'];

                            if ($p['stock'] === 0) {
                                [$kelas, $teks] = ['habis', 'Habis'];
                            } elseif ($p['stock'] <= \App\Data\ProductCatalog::STOK_MENIPIS) {
                                [$kelas, $teks] = ['menipis', 'Menipis'];
                            } else {
                                [$kelas, $teks] = ['aman', 'Aman'];
                            }
                        @endphp
                        <tr>
                            <td class="nama">{{ $p['name'] }}<small>ID {{ $p['id'] }}</small></td>
                            <td data-label="Kategori">{{ $p['category'] }}</td>
                            <td data-label="Harga">Rp {{ number_format($p['price'], 0, ',', '.') }}</td>
                            <td data-label="Status"><span class="lencana {{ $kelas }}">{{ $teks }}</span></td>
                            <td data-label="Stok">
                                <form method="POST" action="{{ route('admin.stok.perbarui', $p['id']) }}" class="form-stok">
                                    @csrf
                                    <input type="number" name="stok" value="{{ $nilai }}" min="0" max="9999" inputmode="numeric" aria-label="Stok {{ $p['name'] }}">
                                    <button type="submit">Simpan</button>
                                </form>
                                @error('stok', $bag)
                                    <div class="error">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
