<?php

namespace App\Http\Controllers;

use App\Data\ProductCatalog;
use App\Services\Keranjang;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function __construct(private Keranjang $keranjang)
    {
    }

    /** Dipanggil dari tombol "Tambah ke Keranjang" di halaman detail produk. */
    public function tambah(Request $request)
    {
        $data = $request->validate([
            'id' => ['required', 'integer'],
            'jumlah' => ['nullable', 'integer', 'min:1', 'max:99'],
        ]);

        $produk = ProductCatalog::find($data['id']);
        abort_if($produk === null, 404);

        $this->keranjang->tambah($produk['name'], $produk['price'], $data['jumlah'] ?? 1);

        return back()->with('sukses', $produk['name'] . ' masuk keranjang.');
    }
}
