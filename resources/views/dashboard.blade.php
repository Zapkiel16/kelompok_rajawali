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
        <div class="search-container">

            <span class="search-icon">⌕</span>

            <input
                type="text"
                placeholder="Cari makanan dan minuman"
            >

        </div>


        <!-- CART -->
        <div class="cart">

            <span class="cart-icon">🛒</span>

            <span class="cart-number">
                0
            </span>

        </div>


        <!-- LOGIN -->
        <button class="login-button">

            <span class="login-icon">◯</span>

            Login sbg tamu

        </button>

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


            <a href="#" class="category-button active">
                Semua Produk
            </a>


            <a href="#" class="category-button">
                Makanan Ringan
            </a>


            <a href="#" class="category-button">
                Minuman
            </a>

        </aside>



        <!-- =================================================
             CONTENT
        ================================================== -->

        <main class="content">


            <!-- =================================================
                 BANNER
            ================================================== -->

            <section class="banner">

                <h2>Banner Promo</h2>

            </section>



            <!-- =================================================
                 MAKANAN RINGAN
            ================================================== -->

            <section class="product-section">


                <div class="section-title">

                    <h2>Makanan Ringan</h2>

                    <a href="#">
                        Lihat semua
                    </a>

                </div>



                <div class="product-grid">

                    @foreach ($snacks as $snack)

                        <div class="product-card">


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
                                    {{ $snack['price'] }}
                                </p>

                            </div>


                        </div>

                    @endforeach

                </div>


            </section>



            <!-- =================================================
                 MINUMAN
            ================================================== -->

            <section class="product-section">


                <div class="section-title">

                    <h2>Minuman</h2>

                    <a href="#">
                        Lihat semua
                    </a>

                </div>



                <div class="product-grid">

                    @foreach ($drinks as $drink)

                        <div class="product-card">


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
                                    {{ $drink['price'] }}
                                </p>

                            </div>


                        </div>

                    @endforeach

                </div>


            </section>


        </main>

    </div>


</body>

</html>