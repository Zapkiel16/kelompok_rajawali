<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Isi Biodata - SnackinAja</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --coklat: #A65510; --krem: #FFFEEB; --gelap: #3A230F; --input-bg: #F6F0D2; --input-garis: #645A30; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Poppins', sans-serif; background: var(--krem); color: var(--gelap); }

        .header { background: var(--coklat); height: 70px; padding: 0 60px; display: flex; align-items: center; justify-content: space-between; }
        .logo { color: #FFD9C7; font-weight: 700; font-size: 22px; text-decoration: none; }
        .label-tamu { border: 2px solid #fff; color: #fff; border-radius: 10px; padding: 8px 22px; font-weight: 600; }

        .wadah { max-width: 680px; margin: 0 auto; padding: 90px 20px 60px; }
        h1 { font-size: clamp(28px, 2.4vw, 40px); font-weight: 700; line-height: 1.2; }
        .sub { font-size: 16px; margin: 8px 0 24px; line-height: 1.7; max-width: 540px; }

        .medan { margin-bottom: 16px; }
        input[type=text], input[type=email] { width: 100%; border: 2px solid var(--input-garis); border-radius: 20px; background: var(--input-bg); padding: 17px 28px; font-family: inherit; font-size: 16px; color: var(--gelap); }
        input::placeholder { color: #8C8260; }
        .error { color: #A3342E; font-size: 13px; margin: 6px 0 0 10px; }

        .tombol { width: 100%; background: var(--coklat); color: #fff; border: none; border-radius: 20px; padding: 17px; font-family: inherit; font-size: 22px; font-weight: 700; cursor: pointer; margin-top: 26px; }
        .tombol:hover { opacity: .92; }
        .kembali { display: inline-block; margin-top: 30px; color: var(--gelap); }
        :focus-visible { outline: 3px solid var(--coklat); outline-offset: 2px; }
        @media (max-width: 600px) { .header { padding: 0 20px; } .wadah { padding-top: 40px; } }
    </style>
</head>
<body>
    <div class="header">
        <a href="/" class="logo">SnackinAja</a>
        <span class="label-tamu">Login sebagai tamu</span>
    </div>

    <div class="wadah">
        <h1>Isi Biodata Anda</h1>
        <p class="sub">Login dengan akun tamu harap mengisi data dibawah ini sebelum mulai belanja</p>

        <form method="POST" action="{{ route('tamu.simpan') }}">
            @csrf
            <div class="medan">
                <input type="text" name="nama" value="{{ old('nama', $tamu['nama'] ?? '') }}" placeholder="Nama Lengkap" aria-label="Nama Lengkap" autocomplete="name" autofocus>
                @error('nama')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="medan">
                <input type="email" name="email" value="{{ old('email', $tamu['email'] ?? '') }}" placeholder="Email" aria-label="Email" autocomplete="email">
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="medan">
                <input type="text" name="no_hp" value="{{ old('no_hp', $tamu['no_hp'] ?? '') }}" placeholder="Nomor HP" aria-label="Nomor HP" autocomplete="tel" inputmode="tel">
                @error('no_hp')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="tombol">Lanjut</button>
        </form>

        <a href="/" class="kembali">Kembali ke halaman utama</a>
    </div>
</body>
</html>
