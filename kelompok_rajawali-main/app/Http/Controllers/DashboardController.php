<?php

namespace App\Http\Controllers;

use App\Data\ProductCatalog;
use App\Services\Keranjang;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request, Keranjang $keranjang)
    {
        $q = trim((string) $request->query('q', ''));

        $kategori = $request->query('kategori');

        if (!in_array(
            $kategori,
            [ProductCatalog::SNACK, ProductCatalog::DRINK],
            true
        )) {
            $kategori = null;
        }

        $cari = fn (array $produk) => $q === ''
            ? $produk
            : array_values(array_filter(
                $produk,
                fn (array $p) => str_contains(
                    mb_strtolower($p['name']),
                    mb_strtolower($q)
                )
            ));

        $snacks = ProductCatalog::byType(ProductCatalog::SNACK);
        $drinks = ProductCatalog::byType(ProductCatalog::DRINK);

        return view('dashboard', [
            'snacks' => $kategori === ProductCatalog::DRINK
                ? []
                : $cari($snacks),

            'drinks' => $kategori === ProductCatalog::SNACK
                ? []
                : $cari($drinks),

            'q' => $q,
            'kategori' => $kategori,
            'jumlahItem' => count($keranjang->semua()),
        ]);
    }
}
