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

            <div class="search-box">
                <input
                    type="text"
                    placeholder="Cari makanan atau minuman..."
                >

                <button type="button">
                    🔍
                </button>
            </div>

        </div>


        <div class="navbar-right">

            <a href="#" class="cart">
                🛒
                <span>Keranjang</span>
            </a>

            <a href="#" class="login-button">
                Login
            </a>

        </div>

    </nav>


    <!-- =========================
         DETAIL PRODUCT
    ========================== -->

    <main class="detail-container">

        <!-- Breadcrumb -->

        <div class="breadcrumb">

            <a href="{{ url('/') }}">
                Home
            </a>

            <span> / </span>

            <span>
                {{ $product['name'] }}
            </span>

        </div>


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

                            <button type="button">
                                −
                            </button>

                            <span>
                                1
                            </span>

                            <button type="button">
                                +
                            </button>

                        </div>

                    </div>


                    <!-- =========================
                         ADD TO CART
                    ========================== -->

                    <form
                        action="#"
                        method="POST"
                        class="cart-form"
                    >

                        @csrf

                        <input
                            type="hidden"
                            name="product_id"
                            value="{{ $id }}"
                        >

                        <input
                            type="hidden"
                            name="quantity"
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

</body>
</html>