<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Services\Keranjang;
use App\Services\Pemesan;
use App\Services\Promo;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(private Keranjang $keranjang, private Promo $promo, private Pemesan $pemesan)
    {
    }

    // Simpan catatan produk dari form ke keranjang. Dipanggil kalau request membawa field "catatan" (kuncinya id item).
    private function simpanCatatan(Request $request): void
    {
        if ($request->has('catatan')) {
            $this->keranjang->simpanCatatan((array) $request->input('catatan'));
        }
    }

    private function kosongKembaliKeKeranjang()
    {
        return redirect()->route('keranjang.index')->with('pesan_error', 'Pilih minimal satu produk dulu sebelum checkout.');
    }

    public function index()
    {
        $items = $this->keranjang->terpilih(); // hanya produk yang dicentang di keranjang
        if ($items === []) {
            return $this->kosongKembaliKeKeranjang();
        }

        $ringkasan = $this->keranjang->ringkasan($items);
        $totalBarang = $ringkasan['barang'];
        $totalHarga = $ringkasan['harga'];

        $totalDiskon = $this->promo->diskon($totalHarga);
        $totalTagihan = $totalHarga - $totalDiskon;
        $kodePromoAktif = $this->promo->aktif()['kode'] ?? null;

        return view('checkout', compact(
            'items', 'totalBarang', 'totalHarga', 'totalDiskon', 'totalTagihan', 'kodePromoAktif'
        ));
    }

    public function terapkanPromo(Request $request)
    {
        $request->validate([
            'kode_promo' => 'required|string',
            'catatan' => 'nullable|array',
            'catatan.*' => 'nullable|string|max:150',
        ]);

        $this->simpanCatatan($request); // supaya catatan yang sudah diketik tidak hilang saat halaman reload

        $kode = $this->promo->terapkan($request->kode_promo);

        if ($kode === null) {
            return redirect()->route('checkout.index')->with('promo_gagal', 'Kode promo tidak ditemukan.');
        }

        return redirect()->route('checkout.index')->with('promo_sukses', 'Kode promo "' . $kode . '" berhasil dipakai.');
    }

    public function hapusPromo(Request $request)
    {
        $request->validate([
            'catatan' => 'nullable|array',
            'catatan.*' => 'nullable|string|max:150',
        ]);

        $this->simpanCatatan($request);
        $this->promo->hapus();
        return redirect()->route('checkout.index');
    }

    public function proses(Request $request)
    {
        $request->validate([
            'metode' => 'required|in:QRIS,Cash',
            'catatan' => 'nullable|array',
            'catatan.*' => 'nullable|string|max:150',
        ]);

        $this->simpanCatatan($request);

        $items = $this->keranjang->terpilih();
        if ($items === []) {
            return $this->kosongKembaliKeKeranjang();
        }

        $totalHarga = $this->keranjang->ringkasan($items)['harga'];
        $totalDiskon = $this->promo->diskon($totalHarga);
        $totalTagihan = $totalHarga - $totalDiskon;

        $pemesan = $this->pemesan->data(); // akun yang login, atau biodata tamu

        $transaksi = Transaksi::create([
            'user_id' => $pemesan['user_id'],
            'nama_pemesan' => $pemesan['nama'],
            'email_pemesan' => $pemesan['email'],
            'no_hp_pemesan' => $pemesan['no_hp'],
            // yang disimpan hanya data pembelian (tanpa id/status centang dari keranjang)
            'items' => array_map(fn (array $item) => [
                'nama' => $item['nama'],
                'harga' => $item['harga'],
                'jumlah' => $item['jumlah'],
                'catatan' => $item['catatan'],
            ], $items),
            'total_harga' => $totalHarga,
            'total_diskon' => $totalDiskon,
            'total_tagihan' => $totalTagihan,
            'metode' => $request->metode,
            'status' => 'menunggu',
        ]);

        $this->pemesan->catatTransaksi($transaksi); // pesanan tamu dicatat supaya bisa dilihat lagi
        $this->keranjang->hapusTerpilih(); // yang sudah dibeli keluar dari keranjang, sisanya tetap ada
        $this->promo->hapus();

        return redirect()->route('checkout.status', $transaksi->id);
    }

    public function status(Transaksi $transaksi)
    {
        // Hanya pemilik pesanan (akun yang sama, atau tamu di browser yang sama) yang boleh melihat
        abort_unless($this->pemesan->bolehMelihat($transaksi), 404);

        return view('checkout-status', compact('transaksi'));
    }
}
