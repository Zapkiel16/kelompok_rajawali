<<<<<<< HEAD

=======
>>>>>>> d118139c80da38a1f353785fb9656acd6f5102b9
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<<<<<<< HEAD

    <title>Profil Saya - SnackinAja</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
          rel="stylesheet">

    <style>
        :root {
            --coklat: #A65510;
            --coklat-gelap: #3A230F;
            --krem: #FFFDE9;
            --krem-kartu: #F9F4D6;
            --putih: #FFFFFF;
            --hijau: #267343;
            --merah: #B42318;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--krem);
            color: var(--coklat-gelap);
            min-height: 100vh;
        }

        .header {
            background: var(--coklat);
            min-height: 70px;
            padding: 0 60px;
            display: flex;
            align-items: center;
            gap: 28px;
        }

        .header .logo {
            color: #FFD9C7;
            font-weight: 700;
            font-size: 22px;
            text-decoration: none;
        }

        .header .cari {
            flex: 1;
            position: relative;
        }

        .header .cari svg {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
        }

        .header .cari input {
            width: 100%;
            border: 2px solid var(--coklat);
            outline: 2px solid white;
            outline-offset: -4px;
            border-radius: 30px;
            background: var(--krem);
            padding: 11px 20px 11px 50px;
            font-family: inherit;
            font-size: 14px;
        }

        .header .ikon-keranjang {
            display: flex;
            text-decoration: none;
        }

        .header .akun {
            position: relative;
        }

        .header .akun summary {
            list-style: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            border: 2px solid white;
            color: white;
            border-radius: 10px;
            padding: 8px 18px;
            font-weight: 600;
        }

        .header .akun summary::-webkit-details-marker {
            display: none;
        }

        .header .menu-akun {
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            min-width: 180px;
            background: var(--krem);
            border: 2px solid var(--coklat);
            border-radius: 12px;
            padding: 6px;
            z-index: 10;
        }

        .header .menu-akun a {
            display: block;
            padding: 10px 14px;
            border-radius: 8px;
            color: var(--coklat-gelap);
            text-decoration: none;
        }

        .header .menu-akun a:hover {
            background: var(--krem-kartu);
        }

        .halaman {
            max-width: 1000px;
            margin: 45px auto;
            padding: 0 20px 40px;
        }

        .judul-halaman {
            margin-bottom: 24px;
        }

        .judul-halaman h1 {
            font-size: 28px;
            color: var(--coklat-gelap);
        }

        .judul-halaman p {
            margin-top: 6px;
            color: #78634D;
            font-size: 14px;
        }

        .kartu-profil {
            display: grid;
            grid-template-columns: 280px 1fr;
            background: var(--putih);
            border: 1px solid #E8DCC3;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(58, 35, 15, 0.06);
        }

        .sisi-profil {
            background: var(--krem-kartu);
            padding: 35px 24px;
            text-align: center;
        }

        .avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin: 0 auto 18px;
            background: var(--coklat);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 38px;
            font-weight: 700;
            border: 5px solid white;
            box-shadow: 0 3px 10px #d7c8a7;
        }

        .sisi-profil h2 {
            font-size: 19px;
            overflow-wrap: anywhere;
        }

        .sisi-profil .label-akun {
            display: inline-block;
            margin-top: 10px;
            padding: 5px 13px;
            background: white;
            border-radius: 20px;
            color: var(--coklat);
            font-size: 12px;
            font-weight: 600;
        }

        .sisi-profil .email-ringkas {
            margin-top: 12px;
            font-size: 12px;
            color: #78634D;
            overflow-wrap: anywhere;
        }

        .isi-profil {
            padding: 35px;
        }

        .isi-profil h2 {
            font-size: 20px;
            margin-bottom: 6px;
        }

        .deskripsi {
            font-size: 13px;
            color: #78634D;
            margin-bottom: 25px;
        }

        .pesan {
            padding: 12px 15px;
            border-radius: 9px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .pesan.sukses {
            color: var(--hijau);
            background: #EAF7ED;
            border: 1px solid #B7E0C1;
        }

        .pesan.error {
            color: var(--merah);
            background: #FFF0EF;
            border: 1px solid #F5C2C0;
        }

        .form-grup {
            margin-bottom: 19px;
        }

        .form-grup label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 600;
        }

        .form-grup input {
            width: 100%;
            border: 1px solid #D8C9AD;
            background: #FFFEF8;
            border-radius: 9px;
            padding: 12px 14px;
            font-family: inherit;
            font-size: 14px;
            color: var(--coklat-gelap);
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }

        .form-grup input:focus {
            border-color: var(--coklat);
            box-shadow: 0 0 0 3px rgba(166, 85, 16, .12);
        }

        .form-grup .error-teks {
            display: block;
            color: var(--merah);
            font-size: 12px;
            margin-top: 5px;
        }

        .petunjuk {
            font-size: 11px;
            color: #78634D;
            margin-top: 6px;
        }

        .aksi {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 25px;
        }

        .tombol {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            border-radius: 9px;
            padding: 12px 20px;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: .2s;
        }

        .tombol-simpan {
            border: 1px solid var(--coklat);
            background: var(--coklat);
            color: white;
        }

        .tombol-simpan:hover {
            background: #87420B;
        }

        .tombol-kembali {
            border: 1px solid #D8C9AD;
            background: white;
            color: var(--coklat-gelap);
        }

        .tombol-kembali:hover {
            background: var(--krem-kartu);
        }

        @media (max-width: 760px) {
            .header {
                padding: 12px 20px;
                gap: 12px;
                flex-wrap: wrap;
            }

            .header .logo {
                margin-right: auto;
            }

            .header .cari {
                display: none;
            }

            .kartu-profil {
                grid-template-columns: 1fr;
            }

            .sisi-profil {
                padding: 28px 20px;
            }

            .isi-profil {
                padding: 25px 20px;
            }

            .judul-halaman h1 {
                font-size: 24px;
            }

            .aksi .tombol {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    @include('partials.header')

    <main class="halaman">
        <div class="judul-halaman">
            <h1>Profil Saya</h1>
            <p>Kelola informasi akun SnackinAja milikmu.</p>
        </div>

        <section class="kartu-profil">
            <aside class="sisi-profil">
                <div class="avatar">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>

                <h2>{{ $user->name }}</h2>

                <span class="label-akun">
                    {{ $user->adalahAdmin() ? 'Administrator' : 'Pengguna' }}
                </span>

                <p class="email-ringkas">{{ $user->email }}</p>
            </aside>

            <div class="isi-profil">
                <h2>Informasi Akun</h2>
                <p class="deskripsi">
                    Perbarui informasi di bawah ini, lalu tekan Simpan Perubahan.
                </p>

                @if (session('success'))
                    <div class="pesan sukses">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="pesan error">
                        Ada data yang belum benar. Periksa kembali isianmu.
                    </div>
                @endif

                <form action="{{ route('profil.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-grup">
                        <label for="name">Nama lengkap</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            maxlength="255"
                            required
                            autocomplete="name"
                        >
                        @error('name')
                            <span class="error-teks">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-grup">
                        <label for="email">Alamat email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            maxlength="255"
                            required
                            autocomplete="email"
                        >
                        @error('email')
                            <span class="error-teks">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-grup">
                        <label for="no_hp">Nomor HP</label>
                        <input
                            type="tel"
                            id="no_hp"
                            name="no_hp"
                            value="{{ old('no_hp', $user->no_hp) }}"
                            pattern="08[0-9]{8,12}"
                            maxlength="14"
                            required
                            autocomplete="tel"
                        >
                        <p class="petunjuk">
                            Gunakan angka saja, diawali 08.
                            Contoh: 081234567890
                        </p>
                        @error('no_hp')
                            <span class="error-teks">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="aksi">
                        <button type="submit" class="tombol tombol-simpan">
                            Simpan Perubahan
                        </button>

                        <a href="{{ route('dashboard') }}"
                           class="tombol tombol-kembali">
                            Kembali ke Toko
                        </a>
                    </div>
                </form>
            </div>
        </section>
    </main>
</body>
</html>
=======
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
>>>>>>> d118139c80da38a1f353785fb9656acd6f5102b9
