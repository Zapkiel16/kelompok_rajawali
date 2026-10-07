<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('judul') - SnackinAja</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --coklat: #A65510;
            --krem: #FFFEEB;
            --gelap: #3A230F;
            --input-bg: #F6F0D2;
            --input-garis: #645A30;
            --teks-panel: #EFE6BE;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Poppins', sans-serif; background: var(--krem); color: var(--gelap); }

        .halaman { display: grid; grid-template-columns: 1fr 1fr; min-height: 100vh; }
        .gambar { background: var(--coklat); color: var(--teks-panel); display: flex; align-items: center; justify-content: center; text-align: center; font-weight: 700; font-size: clamp(32px, 4.2vw, 64px); line-height: 1.5; padding: 40px; }
        .sisi-form { display: flex; align-items: center; padding: 40px clamp(24px, 5.5vw, 110px); }
        .kotak { width: 100%; max-width: 730px; }

        h1 { font-size: clamp(28px, 2.4vw, 40px); font-weight: 700; line-height: 1.2; }
        .sub { font-size: clamp(14px, 1.1vw, 18px); margin: 6px 0 28px; line-height: 1.6; max-width: 560px; }

        .medan { margin-bottom: 18px; }
        input[type=text], input[type=email], input[type=password] {
            width: 100%; border: 2px solid var(--input-garis); border-radius: 20px; background: var(--input-bg);
            padding: 17px 28px; font-family: inherit; font-size: 16px; color: var(--gelap);
        }
        input::placeholder { color: #8C8260; }
        input[readonly] { opacity: .75; }

        .tombol { width: 100%; background: var(--coklat); color: #fff; border: none; border-radius: 20px; padding: 17px; font-family: inherit; font-size: clamp(18px, 1.6vw, 24px); font-weight: 700; cursor: pointer; margin-top: 6px; }
        .tombol:hover { opacity: .92; }

        .tautan-kanan { text-align: right; margin: -6px 0 18px; font-size: 15px; }
        .tengah { text-align: center; }
        .atau { margin: 18px 0 8px; }
        .bawah { margin-top: 44px; font-size: 16px; }
        a { color: var(--gelap); }
        .tebal { font-weight: 700; }

        .error { color: #A3342E; font-size: 13px; margin: 6px 0 0 10px; }
        .info-hijau { background: #E3F4D8; color: #2E6B1A; border-radius: 14px; padding: 12px 18px; margin-bottom: 20px; font-size: 14px; }
        .info-krem { background: var(--input-bg); border: 2px solid var(--input-garis); border-radius: 14px; padding: 12px 18px; margin-bottom: 20px; font-size: 14px; }

        :focus-visible { outline: 3px solid var(--coklat); outline-offset: 2px; }

        @media (max-width: 860px) {
            .halaman { grid-template-columns: 1fr; }
            .gambar { display: none; }
            .sisi-form { padding: 40px 24px; min-height: 100vh; }
        }
    </style>
</head>
<body>
    <div class="halaman">
        <div class="gambar">PLACEHOLDER<br>GAMBAR</div>
        <div class="sisi-form">
            <div class="kotak">
                @yield('isi')
            </div>
        </div>
    </div>
</body>
</html>
