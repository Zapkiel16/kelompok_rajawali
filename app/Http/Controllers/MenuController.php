<?php

namespace App\Http\Controllers;

use App\Services\Keranjang;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function __construct(private Keranjang $keranjang)
    {
    }

    /** Data sementara sampai halaman produk dari kelompok selesai. */
    private function produk(): array
    {
        return [
            ['id' => 1, 'nama' => 'Superstar Jumbo Triple Coklat Banget', 'harga' => 5000],
            ['id' => 2, 'nama' => 'Pop Mie Enak Mantap Super Pedas', 'harga' => 6000],
            ['id' => 3, 'nama' => 'Kue Lapis Khas Ngawi Tumpuk Banyak', 'harga' => 3000],
            ['id' => 4, 'nama' => 'Roti O asli Stasiun Lempuyangan Manis', 'harga' => 7000],
            ['id' => 5, 'nama' => 'Es Teh Manis Jumbo', 'harga' => 4000],
            ['id' => 6, 'nama' => 'Kopi Susu Gula Aren', 'harga' => 8000],
        ];
    }

    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $produk = collect($this->produk())
            ->when($q !== '', fn ($c) => $c->filter(
                fn ($p) => str_contains(mb_strtolower($p['nama']), mb_strtolower($q))
            ))
            ->values();

        return view('menu', [
            'produk' => $produk,
            'q' => $q,
            'jumlahItem' => count($this->keranjang->semua()),
        ]);
    }

    public function tambah(Request $request)
    {
        $data = $request->validate(['id' => ['required', 'integer']]);

        $produk = collect($this->produk())->firstWhere('id', $data['id']);
        abort_if($produk === null, 404);

        $this->keranjang->tambah($produk['nama'], $produk['harga']);

        return back()->with('sukses', $produk['nama'] . ' masuk keranjang.');
    }
}