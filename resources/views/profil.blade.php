<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil - SnackinAja</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --coklat: #A65510; --krem: #FFFDE9; --krem-kartu: #F9F4D6; --gelap: #3A230F; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Poppins', sans-serif; background: var(--krem); color: var(--coklat); }
        .header { background: var(--coklat); height: 70px; padding: 0 60px; display: flex; align-items: center; }
        .logo { color: #FFD9C7; font-weight: 700; font-size: 22px; }
        .wadah { max-width: 600px; margin: 60px auto; background: var(--krem-kartu); border-radius: 20px; padding: 40px; text-align: center; }
        h1 { color: var(--gelap); margin-bottom: 16px; }
        p { margin-bottom: 20px; font-size: 14px; }
        .wadah a { color: var(--coklat); font-weight: 600; }
    </style>
</head>
<body>
    @include('partials.header')
    <div class="wadah">
        <h1>Halaman Profil</h1>
        <p>Ini placeholder nanti diganti dengan halaman pengaturan profil yang beneran cuy hehe. </p>
        <p><span style="font-size: 50px;">😏</span></p>
        <a href="/">Kembali ke halaman utama</a><br><br><a href="{{ route('logout.konfirmasi') }}">Keluar</a>
    </div>
</body>
</html>