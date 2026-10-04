<?php

namespace App\Http\Controllers;

use App\Services\Keranjang;
use App\Services\Pemesan;

class PesananController extends Controller
{
    public function __construct(private Pemesan $pemesan, private Keranjang $keranjang)
    {
    }

    // Daftar pesanan beserta statusnya
    public function index()
    {
        return view('pesanan', [
            'daftar' => $this->pemesan->daftarTransaksi(),
            'jumlahItem' => count($this->keranjang->semua()),
        ]);
    }
}
