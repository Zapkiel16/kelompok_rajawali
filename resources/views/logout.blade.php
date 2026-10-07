<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Keluar - SnackinAja</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --coklat: #A65510; --krem: #FFFDE9; --krem-kartu: #F9F4D6; --gelap: #3A230F; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Poppins', sans-serif; background: var(--krem); color: var(--coklat); }
        .header { background: var(--coklat); height: 70px; padding: 0 60px; display: flex; align-items: center; }
        .logo { color: #FFD9C7; font-weight: 700; font-size: 22px; text-decoration: none; }
        .wadah { max-width: 520px; margin: 80px auto; background: var(--krem-kartu); border-radius: 20px; padding: 40px; }
        h1 { color: var(--gelap); font-size: 26px; margin-bottom: 10px; }
        p { font-size: 15px; margin-bottom: 28px; line-height: 1.6; }
        .tombol { display: flex; gap: 12px; }
        .tombol form { flex: 1; }
        .tombol button, .tombol a { display: block; width: 100%; text-align: center; padding: 14px; border-radius: 10px; font-family: inherit; font-size: 16px; font-weight: 700; text-decoration: none; cursor: pointer; border: 2px solid var(--coklat); }
        .keluar { background: var(--coklat); color: #fff; }
        .batal { flex: 1; background: transparent; color: var(--coklat); }
        .tombol button:hover, .tombol a:hover { opacity: .9; }
        :focus-visible { outline: 3px solid var(--gelap); outline-offset: 2px; }
        @media (max-width: 600px) { .header { padding: 0 20px; } .wadah { margin: 40px 16px; padding: 28px; } .tombol { flex-direction: column; } }
    </style>
</head>
<body>
    @include('partials.header')

    <div class="wadah">
        <h1>Keluar dari akun?</h1>
        <p>Kamu akan keluar dari SnackinAja. Produk di keranjang yang belum di-checkout ikut dikosongkan.</p>

        <div class="tombol">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="keluar">Ya, keluar</button>
            </form>
            <a href="/" class="batal">Batal</a>
        </div>
    </div>
</body>
</html>