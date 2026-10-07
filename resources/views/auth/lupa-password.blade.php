@extends('auth.layout')

@section('judul', 'Lupa Password')

@section('isi')
    <h1>Lupa Password</h1>
    <p class="sub">Masukkan email yang terdaftar, kami akan mengirim link untuk atur ulang password.</p>

    @if (session('status'))
        <div class="info-hijau">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('lupa.kirim') }}">
        @csrf
        <div class="medan">
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" aria-label="Email" autocomplete="email" autofocus>
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="tombol">Reset</button>
    </form>

    <p class="bawah"><a href="/">Kembali ke halaman utama</a></p>
@endsection
