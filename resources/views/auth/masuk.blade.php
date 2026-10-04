@extends('auth.layout')

@section('judul', 'Masuk')

@section('isi')
    <h1>Masuk ke Akun</h1>
    <p class="sub">Lihat semua menu yang ada disini</p>

    @if (session('status'))
        <div class="info-hijau">{{ session('status') }}</div>
    @endif
    @if (session('pesan'))
        <div class="info-krem">{{ session('pesan') }}</div>
    @endif

    <form method="POST" action="{{ route('masuk.proses') }}">
        @csrf
        <div class="medan">
            <input type="text" name="akun" value="{{ old('akun') }}" placeholder="Email atau Nomor HP" aria-label="Email atau Nomor HP" autocomplete="username" autofocus>
            @error('akun')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="medan">
            <input type="password" name="password" placeholder="Password" aria-label="Password" autocomplete="current-password">
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="tautan-kanan"><a href="{{ route('lupa') }}">Lupa password?</a></div>

        <button type="submit" class="tombol">Masuk</button>
    </form>

    <p class="tengah atau">Atau</p>
    <p class="tengah"><a href="{{ route('tamu') }}">Masuk sebagai tamu</a></p>

    <p class="bawah">Belum punya akun? <a href="{{ route('daftar') }}" class="tebal">Daftar Sekarang</a></p>
      <p class="tengah" style="margin-top: 16px;"><a href="/">Kembali ke halaman utama</a></p>
@endsection
