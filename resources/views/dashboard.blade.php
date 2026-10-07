<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SnackinAja - Dashboard</title>

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

</head>


<body>


    <!-- =====================================================
         NAVBAR
    ====================================================== -->

    <header class="navbar">

        <!-- LOGO -->
        <div class="logo">

            <div class="logo-icon">
                🍟
            </div>

            <div class="logo-text">

                <h1>SnackinAja</h1>

                <span>SNACK & DRINK</span>

            </div>

        </div>


        <!-- SEARCH -->
        <form class="search-container" action="{{ url('/') }}" method="GET" role="search">

            <span class="search-icon">⌕</span>

            <input
                type="text"
                name="q"
                value="{{ $q }}"
                placeholder="Cari makanan dan minuman"
            >

            @if ($kategori)
                <input type="hidden" name="kategori" value="{{ $kategori }}">
            @endif

        </form>


        <!-- CART -->
        <a href="{{ route('keranjang.index') }}" class="cart" aria-label="Keranjang">

            <span class="cart-icon">🛒</span>

            @if ($jumlahItem > 0)
                <span class="cart-number">{{ $jumlahItem }}</span>
            @endif

        </a>


        <!-- LOGIN -->
        <div class="auth-actions">

            @if (auth()->check() || session()->has('tamu'))

                <details class="akun">

                    <summary class="login-button">
                        <span class="login-icon">◯</span>
                        {{ auth()->check() ? auth()->user()->name : session('tamu.nama') }}
                    </summary>

                    <div class="menu-akun">

                        @if (auth()->check())
                            <a href="{{ route('profil.index') }}">Profil</a>
                        @endif

                        <a href="{{ route('pesanan.index') }}">Pesanan Saya</a>

                        <a href="{{ route('logout.konfirmasi') }}">Keluar</a>

                    </div>

                </details>

            @else

                <a href="{{ route('masuk') }}" class="login-button">Masuk</a>

                <a href="{{ route('daftar') }}" class="login-button login-daftar">Daftar</a>

            @endif

        </div>

    </header>



    <!-- =====================================================
         MAIN LAYOUT
    ====================================================== -->

    <div class="main-layout">


        <!-- =================================================
             SIDEBAR
        ================================================== -->

        <aside class="sidebar">

            <h2>Kategori</h2>


            <a href="{{ route('dashboard') }}"
               class="category-button {{ $kategori === null ? 'active' : '' }}">
                Semua Produk
            </a>


            <a href="{{ route('dashboard', ['kategori' => 'snack']) }}"
               class="category-button {{ $kategori === 'snack' ? 'active' : '' }}">
                Makanan Ringan
            </a>


            <a href="{{ route('dashboard', ['kategori' => 'drink']) }}"
               class="category-button {{ $kategori === 'drink' ? 'active' : '' }}">
                Minuman
            </a>

        </aside>



        <!-- =================================================
             CONTENT
        ================================================== -->

        <main class="content">

            @if (session('sukses'))
                <div class="flash-sukses">{{ session('sukses') }}</div>
            @endif

            @if ($q !== '')
                <p class="hasil-cari">
                    Hasil pencarian untuk "{{ $q }}" —
                    <a href="{{ url('/') }}">tampilkan semua</a>
                </p>
            @endif


            <!-- =================================================
                 BANNER
            ================================================== -->

            <section class="banner">

                <div class="banner-track">
                    <div class="banner-slide"><h2>Banner Promo 1</h2></div>
                    <div class="banner-slide"><h2>Banner Promo 2</h2></div>
                    <div class="banner-slide"><h2>Banner Promo 3</h2></div>
                </div>

                <button type="button" class="banner-arrow banner-prev" aria-label="Sebelumnya">‹</button>
                <button type="button" class="banner-arrow banner-next" aria-label="Berikutnya">›</button>

                <div class="banner-dots">
                    <button type="button" class="active" aria-label="Halaman 1"></button>
                    <button type="button" aria-label="Halaman 2"></button>
                    <button type="button" aria-label="Halaman 3"></button>
                </div>

            </section>



            <!-- =================================================
                 MAKANAN RINGAN
            ================================================== -->

            @if (count($snacks) > 0)

            <section class="product-section">


                <div class="section-title">

                    <h2>Makanan Ringan</h2>

                    @if ($kategori === null)
                        <a href="{{ route('dashboard', ['kategori' => 'snack']) }}">Lihat semua</a>
                    @else
                        <a href="{{ route('dashboard') }}">← Semua produk</a>
                    @endif

                </div>



                <div class="product-grid">

                    @foreach ($snacks as $snack)

                        <a href="{{ route('product.detail', $snack['id']) }}" class="product-card">


                            <!-- PRODUCT IMAGE -->

                            <div class="product-image">

                                @if ($snack['image'])

                                    <img
                                        src="{{ asset($snack['image']) }}"
                                        alt="{{ $snack['name'] }}"
                                    >

                                @else

                                    <span>
                                        Foto Produk
                                    </span>

                                @endif

                            </div>



                            <!-- PRODUCT INFORMATION -->

                            <div class="product-information">

                                <h3>
                                    {{ $snack['name'] }}
                                </h3>

                                <p>
                                    Rp {{ number_format($snack['price'], 0, ',', '.') }}
                                </p>

                            </div>


                        </a>

                    @endforeach

                </div>


            </section>

            @endif



            <!-- =================================================
                 MINUMAN
            ================================================== -->

            @if (count($drinks) > 0)

            <section class="product-section">


                <div class="section-title">

                    <h2>Minuman</h2>

                    @if ($kategori === null)
                        <a href="{{ route('dashboard', ['kategori' => 'drink']) }}">Lihat semua</a>
                    @else
                        <a href="{{ route('dashboard') }}">← Semua produk</a>
                    @endif

                </div>



                <div class="product-grid">

                    @foreach ($drinks as $drink)

                        <a href="{{ route('product.detail', $drink['id']) }}" class="product-card">


                            <!-- PRODUCT IMAGE -->

                            <div class="product-image">

                                @if ($drink['image'])

                                    <img
                                        src="{{ asset($drink['image']) }}"
                                        alt="{{ $drink['name'] }}"
                                    >

                                @else

                                    <span>
                                        Foto Produk
                                    </span>

                                @endif

                            </div>



                            <!-- PRODUCT INFORMATION -->

                            <div class="product-information">

                                <h3>
                                    {{ $drink['name'] }}
                                </h3>

                                <p>
                                    Rp {{ number_format($drink['price'], 0, ',', '.') }}
                                </p>

                            </div>


                        </a>

                    @endforeach

                </div>


            </section>

            @endif


        @if (count($snacks) === 0 && count($drinks) === 0)
                <p class="kosong">Jajanan yang kamu cari belum ada.</p>
            @endif

        </main>

    </div>


<script>
    (function () {
        var track = document.querySelector('.banner-track');
        if (!track) return;

        var dots = document.querySelectorAll('.banner-dots button');
        var total = dots.length;

        function halaman() {
            return Math.round(track.scrollLeft / track.clientWidth);
        }

        function pindah(i) {
            i = (i + total) % total; // dari halaman terakhir lanjut ke pertama, dan sebaliknya
            track.scrollTo({ left: i * track.clientWidth, behavior: 'smooth' });
        }

        track.addEventListener('scroll', function () {
            var p = halaman();
            dots.forEach(function (d, i) { d.classList.toggle('active', i === p); });
        });

        document.querySelector('.banner-prev').addEventListener('click', function () { pindah(halaman() - 1); });
        document.querySelector('.banner-next').addEventListener('click', function () { pindah(halaman() + 1); });
        dots.forEach(function (d, i) { d.addEventListener('click', function () { pindah(i); }); });
    })();
</script>

</body>

</html>