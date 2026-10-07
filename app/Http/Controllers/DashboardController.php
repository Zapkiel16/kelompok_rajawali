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

        // null = semua kategori
        $kategori = $request->query('kategori');
        if (! in_array($kategori, [ProductCatalog::SNACK, ProductCatalog::DRINK], true)) {
            $kategori = null;
        }

        $cari = fn (array $produk) => $q === ''
            ? $produk
            : array_values(array_filter(
                $produk,
                fn (array $p) => str_contains(mb_strtolower($p['name']), mb_strtolower($q))
            ));

        return view('dashboard', [
            'snacks' => $kategori === ProductCatalog::DRINK ? [] : $cari(ProductCatalog::byType(ProductCatalog::SNACK)),
            'drinks' => $kategori === ProductCatalog::SNACK ? [] : $cari(ProductCatalog::byType(ProductCatalog::DRINK)),
            'q' => $q,
            'kategori' => $kategori,
            'jumlahItem' => count($keranjang->semua()),
        ]);
    }
}