<?php

namespace App\Http\Controllers;

use App\Data\ProductCatalog;
use App\Services\Keranjang;

class DetailController extends Controller
{
    public function index(Keranjang $keranjang, int $id = 1)
    {
        $product = ProductCatalog::find($id);

        // Jika ID produk tidak ditemukan
        abort_if($product === null, 404);

        return view('detail', [
            'product' => $product,
            'id' => $id,
            'jumlahItem' => count($keranjang->semua()),
        ]);
    }
}
