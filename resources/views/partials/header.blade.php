{{-- Header bersama. Variabel: $jumlahItem (jumlah produk di keranjang, boleh kosong) --}}
<style>
    .header { background: #A65510; height: 70px; padding: 0 60px; display: flex; align-items: center; gap: 28px; }
    .header .logo { color: #FFD9C7; font-weight: 700; font-size: 22px; text-decoration: none; }
    .header .cari { flex: 1; position: relative; }
    .header .cari svg { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); }
    .header .cari input { width: 100%; border: 2px solid #A65510; outline: 2px solid #fff; outline-offset: -4px; border-radius: 30px; background: #FFFDE9; padding: 11px 20px 11px 50px; font-family: inherit; font-size: 15px; color: #3A230F; }
    .header .cari input::placeholder { color: #A65510; opacity: .7; }
    .header .ikon-keranjang { position: relative; display: flex; }
    .header .lencana { position: absolute; top: -8px; right: -10px; background: #FFD9C7; color: #A65510; border-radius: 10px; min-width: 20px; height: 20px; padding: 0 5px; font-size: 12px; font-weight: 700; display: flex; align-items: center; justify-content: center; }
    .header .akun { position: relative; }
    .header .akun summary { list-style: none; cursor: pointer; display: flex; align-items: center; gap: 10px; border: 2px solid #fff; color: #fff; border-radius: 10px; padding: 8px 18px; font-weight: 600; }
    .header .akun summary::-webkit-details-marker { display: none; }
    .header .menu-akun { position: absolute; right: 0; top: calc(100% + 8px); min-width: 180px; background: #FFFDE9; border: 2px solid #A65510; border-radius: 12px; padding: 6px; z-index: 10; }
    .header .menu-akun a { display: block; padding: 10px 14px; border-radius: 8px; color: #3A230F; font-weight: 500; text-decoration: none; }
    .header .menu-akun a:hover { background: #F9F4D6; }
    .header .aksi-masuk { display: flex; gap: 12px; }
    .header .btn-masuk, .header .btn-daftar { border: 2px solid #fff; border-radius: 10px; padding: 8px 22px; font-weight: 600; text-decoration: none; }
    .header .btn-masuk { color: #fff; }
    .header .btn-daftar { background: #fff; color: #A65510; }
    @media (max-width: 860px) {
        .header { padding: 0 20px; gap: 14px; }
        .header .cari { display: none; }
        .header .logo { margin-right: auto; }
    }
</style>
<div class="header">
    <a href="/" class="logo">SnackinAja</a>

    <form class="cari" action="/" method="GET" role="search">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#A65510" stroke-width="2" stroke-linecap="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
        <input type="search" name="q" placeholder="Cari makanan dan minuman" aria-label="Cari makanan dan minuman">
    </form>

    <a href="{{ route('keranjang.index') }}" class="ikon-keranjang" aria-label="Keranjang">
        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="9" cy="20" r="1.5"/><circle cx="18" cy="20" r="1.5"/><path d="M2 3h3l2.6 12.4a1 1 0 0 0 1 .8h8.8a1 1 0 0 0 1-.8L20 7H6"/></svg>
        @if (($jumlahItem ?? 0) > 0)
            <span class="lencana">{{ $jumlahItem }}</span>
        @endif
    </a>

    @if (auth()->check() || session()->has('tamu'))
        <details class="akun">
            <summary>
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="10" r="3"/><path d="M6.2 18.5a6.5 6.5 0 0 1 11.6 0"/></svg>
                {{ auth()->check() ? auth()->user()->name : session('tamu.nama') }}
            </summary>
            <div class="menu-akun">
                @if (auth()->check())
                    <a href="{{ route('profil.index') }}">Profil</a>
                    @if ((bool) auth()->user()->is_admin)
                        <a href="{{ route('admin.stok') }}">Kelola Stok</a>
                    @endif
                @endif
                <a href="{{ route('pesanan.index') }}">Pesanan Saya</a>
                <a href="{{ route('logout.konfirmasi') }}">Keluar</a>
            </div>
        </details>
    @else
        <div class="aksi-masuk">
            <a href="{{ route('masuk') }}" class="btn-masuk">Masuk</a>
            <a href="{{ route('daftar') }}" class="btn-daftar">Daftar</a>
        </div>
    @endif
</div>
