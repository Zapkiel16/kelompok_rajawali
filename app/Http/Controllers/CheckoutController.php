<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{

    private function ambilItem(): array
    {
        return session('keranjang', [
            ['nama' => 'Superstar Jumbo Triple Coklat Banget', 'harga' => 5000, 'jumlah' => 1],
            ['nama' => 'Kue Lapis Khas Ngawi Tumpuk Banyak', 'harga' => 3000, 'jumlah' => 1],
        ]);
    }

    public function index()
    {
        $items = $this->ambilItem();

        $totalBarang = 0;
        $totalHarga = 0;
        foreach ($items as $item) {
            $totalBarang += $item['jumlah'];
            $totalHarga += $item['harga'] * $item['jumlah'];
        }

        $totalDiskon = 0; // belum ada promo
        $totalTagihan = $totalHarga - $totalDiskon;

        return view('checkout', compact('items', 'totalBarang', 'totalHarga', 'totalDiskon', 'totalTagihan'));
    }

    public function proses(Request $request)
    {
        $request->validate([
            'metode' => 'required|in:QRIS,Cash',
        ]);

        $items = $this->ambilItem();

        $totalHarga = 0;
        foreach ($items as $item) {
            $totalHarga += $item['harga'] * $item['jumlah'];
        }
        $totalDiskon = 0;
        $totalTagihan = $totalHarga - $totalDiskon;

        $transaksi = Transaksi::create([
            'items' => $items,
            'total_harga' => $totalHarga,
            'total_diskon' => $totalDiskon,
            'total_tagihan' => $totalTagihan,
            'metode' => $request->metode,
            'status' => 'menunggu',
        ]);

        session()->forget('keranjang'); // keranjang dikosongkan setelah checkout

        return redirect()->route('checkout.status', $transaksi->id);
    }

    public function status(Transaksi $transaksi)
    {
        return view('checkout-status', compact('transaksi'));
    }
}