@extends('auth.layout')

@section('judul', 'Daftar')

@section('isi')
    <h1>Buat Akun Baru</h1>
    <p class="sub">Daftar untuk mulai belanja</p>

    <form method="POST" action="{{ route('daftar.proses') }}">
        @csrf
        <div class="medan">
            <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Nama Lengkap" aria-label="Nama Lengkap" autocomplete="name" autofocus>
            @error('nama')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="medan">
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" aria-label="Email" autocomplete="email">
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="medan">
            <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="Nomor HP" aria-label="Nomor HP" autocomplete="tel" inputmode="tel">
            @error('no_hp')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="medan">
            <input type="password" name="password" placeholder="Password" aria-label="Password" autocomplete="new-password">
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="medan">
            <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" aria-label="Konfirmasi Password" autocomplete="new-password">
        </div>

        <button type="submit" class="tombol">Daftar</button>
    </form>

    <p class="bawah">Sudah punya akun? <a href="{{ route('masuk') }}" class="tebal">Masuk disini</a></p>
    <p class="tengah" style="margin-top: 16px;"><a href="/">Kembali ke halaman utama</a></p>
@endsection
