@extends('auth.layout')

@section('judul', 'Atur Ulang Password')

@section('isi')
    <h1>Atur Ulang Password</h1>
    <p class="sub">Buat password baru untuk akunmu.</p>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="medan">
            <input type="email" name="email" value="{{ old('email', $email) }}" placeholder="Email" aria-label="Email" readonly>
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="medan">
            <input type="password" name="password" placeholder="Password baru" aria-label="Password baru" autocomplete="new-password" autofocus>
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="medan">
            <input type="password" name="password_confirmation" placeholder="Konfirmasi Password baru" aria-label="Konfirmasi Password baru" autocomplete="new-password">
        </div>

        <button type="submit" class="tombol">Simpan Password</button>
    </form>

    <p class="bawah"><a href="{{ route('masuk') }}">Kembali ke halaman masuk</a></p>
@endsection
