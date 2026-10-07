<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $product['name'] }} - SnackinAja</title>

    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
</head>

<body>

    <!-- =========================
         NAVBAR
    ========================== -->

    <nav class="navbar">

        <div class="navbar-left">

            <a href="{{ url('/') }}" class="logo">
                SnackinAja
            </a>

            <form class="search-box" action="{{ url('/') }}" method="GET" role="search">
                <input
                    type="text"
                    name="q"
                    placeholder="Cari makanan atau minuman..."
                >

                <button type="submit">
                    🔍
                </button>
            </form>

        </div>


        <div class="navbar-right">

            <a href="{{ route('keranjang.index') }}" class="cart">
                🛒
                <span>
                    Keranjang
                    @if ($jumlahItem > 0)
                        ({{ $jumlahItem }})
                    @endif
                </span>
            </a>

            @if (auth()->check() || session()->has('tamu'))

                <details class="akun">
                    <summary class="login-button">
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

                <a href="{{ route('masuk') }}" class="login-button">
                    Masuk
                </a>

            @endif

        </div>

    </nav>


    <!-- =========================
         DETAIL PRODUCT
    ========================== -->

    <main class="detail-container">

        <!-- Tombol kembali + Breadcrumb -->

        <div class="detail-topbar">

            <a href="{{ url('/') }}" class="tombol-kembali">
                ← Kembali
            </a>

            <div class="breadcrumb">

            <a href="{{ url('/') }}">
                Home
            </a>

            <span> / </span>

            <span>
                {{ $product['name'] }}
            </span>

        </div>

        </div>


        @if (session('sukses'))
            <div class="flash-sukses">
                {{ session('sukses') }}
                <a href="{{ route('keranjang.index') }}">Lihat keranjang</a>
            </div>
        @endif


        <!-- Detail Card -->

        <div class="detail-card">


            <!-- =========================
                 PRODUCT IMAGE
            ========================== -->

            <div class="product-image-container">

                @if ($product['image'])

                    <img
                        src="{{ asset($product['image']) }}"
                        alt="{{ $product['name'] }}"
                        class="product-image"
                    >

                @else

                    <div class="image-placeholder">

                        <span>Image</span>

                    </div>

                @endif

            </div>


            <!-- =========================
                 PRODUCT INFORMATION
            ========================== -->

            <div class="product-information">

                <!-- Category -->

                <div class="category">
                    {{ $product['category'] }}
                </div>


                <!-- Product Name -->

                <h1>
                    {{ $product['name'] }}
                </h1>


                <!-- Price -->

                <div class="price">
                    Rp {{ number_format($product['price'], 0, ',', '.') }}
                </div>


                <!-- Stock -->

                @if ($product['stock'] > 0)

                    <div class="stock available">
                        Tersedia
                    </div>

                @else

                    <div class="stock out-of-stock">
                        Kosong
                    </div>

                @endif


                <!-- Description -->

                <div class="description">

                    <h3>
                        Deskripsi
                    </h3>

                    <p>
                        {{ $product['description'] }}
                    </p>

                </div>


                <!-- =========================
                     QUANTITY
                ========================== -->

                @if ($product['stock'] > 0)

                    <div class="quantity-section">

                        <label>
                            Jumlah
                        </label>

                        <div class="quantity-control">

                            <button type="button" data-qty="-1">
                                −
                            </button>

                            <span id="qty-text">
                                1
                            </span>

                            <button type="button" data-qty="1">
                                +
                            </button>

                        </div>

                    </div>


                    <!-- =========================
                         ADD TO CART
                    ========================== -->

                    <form
                        action="{{ route('menu.tambah') }}"
                        method="POST"
                        class="cart-form"
                    >

                        @csrf

                        <input
                            type="hidden"
                            name="id"
                            value="{{ $id }}"
                        >

                        <input
                            type="hidden"
                            name="jumlah"
                            id="qty-input"
                            value="1"
                        >

                        <button
                            type="submit"
                            class="add-cart-button"
                        >
                            🛒
                            Tambah ke Keranjang
                        </button>

                    </form>

                @else

                    <button
                        type="button"
                        class="add-cart-button disabled"
                        disabled
                    >
                        Stok Kosong
                    </button>

                @endif


                <!-- Back -->

                <a
                    href="{{ url('/') }}"
                    class="back-button"
                >
                    ← Kembali ke Produk
                </a>

            </div>

        </div>

    </main>

    @if ($product['stock'] > 0)
        <script>
            (function () {
                var max = {{ min(99, (int) $product['stock']) }};
                var jumlah = 1;
                var teks = document.getElementById('qty-text');
                var input = document.getElementById('qty-input');

                document.querySelectorAll('[data-qty]').forEach(function (tombol) {
                    tombol.addEventListener('click', function () {
                        jumlah = Math.max(1, Math.min(max, jumlah + parseInt(tombol.dataset.qty, 10)));
                        teks.textContent = jumlah;
                        input.value = jumlah;
                    });
                });
            })();
        </script>
    @endif

</body>
</html>