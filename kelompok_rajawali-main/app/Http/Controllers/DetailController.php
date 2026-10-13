<?php

namespace App\Http\Controllers;

use App\Data\ProductCatalog;
use App\Services\Keranjang;

class DetailController extends Controller
{
    public function index(Keranjang $keranjang, int $id)
    {
        $product = ProductCatalog::find($id);

        abort_if($product === null, 404);

        return view('detail', [
            'product' => $product,
            'id' => $id,
            'jumlahItem' => count($keranjang->semua()),
        ]);
    }
}