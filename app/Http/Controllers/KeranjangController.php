<?php

namespace App\Http\Controllers;

use App\Services\Keranjang;
use App\Services\Promo;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function __construct(private Keranjang $keranjang, private Promo $promo)
    {
    }

    public function index()
    {
        $items = $this->keranjang->semua();
        $ringkasan = $this->keranjang->ringkasan($this->keranjang->terpilih());

        $totalDiskon = $this->promo->diskon($ringkasan['harga']);

        return view('keranjang', [
            'items' => $items,
            'totalBarang' => $ringkasan['barang'],
            'subtotal' => $ringkasan['harga'],
            'totalDiskon' => $totalDiskon,
            'totalTagihan' => $ringkasan['harga'] - $totalDiskon,
            'promoAktif' => $this->promo->aktif(),
        ]);
    }

    /**
     * Semua tombol di halaman keranjang (+, -, hapus, promo, checkout) mengirim satu form yang sama.
     * Jadi centang & catatan selalu tersimpan dulu, baru aksinya dijalankan.
     */
    public function perbarui(Request $request)
    {
        $request->validate([
            'aksi' => ['required', 'regex:/^(?:(?:tambah|kurang|hapus):\d+|checkout|promo|hapuspromo|simpan)$/D'],
            'kode_promo' => ['nullable', 'string', 'max:30'],
            'dipilih' => ['nullable', 'array'],
            'dipilih.*' => ['integer'],
            'catatan' => ['nullable', 'array'],
            'catatan.*' => ['nullable', 'string', 'max:150'],
        ]);

        $this->keranjang->sinkron(
            (array) $request->input('dipilih', []),
            (array) $request->input('catatan', []),
        );

        [$aksi, $id] = array_pad(explode(':', $request->input('aksi'), 2), 2, null);
        $id = (int) $id;

        if ($aksi === 'checkout') {
            if ($this->keranjang->terpilih() === []) {
                return redirect()->route('keranjang.index')->with('pesan_error', 'Pilih minimal satu produk dulu sebelum checkout.');
            }

            return redirect()->route('checkout.index');
        }

        if ($aksi === 'promo') {
            $kode = trim((string) $request->input('kode_promo', ''));
            if ($kode === '') {
                return redirect()->route('keranjang.index')->with('promo_gagal', 'Masukkan kode promo dulu.');
            }

            $dipakai = $this->promo->terapkan($kode);
            if ($dipakai === null) {
                return redirect()->route('keranjang.index')->with('promo_gagal', 'Kode promo tidak ditemukan.');
            }

            return redirect()->route('keranjang.index')->with('promo_sukses', 'Kode promo "' . $dipakai . '" berhasil dipakai.');
        }

        if ($aksi === 'hapuspromo') {
            $this->promo->hapus();

            return redirect()->route('keranjang.index');
        }

        if ($aksi === 'simpan') {
            return redirect()->route('keranjang.index');
        }

        if ($aksi === 'hapus') {
            $this->keranjang->hapus($id);

            return redirect()->route('keranjang.index');
        }

        $this->keranjang->ubahJumlah($id, $aksi === 'tambah' ? 1 : -1);

        return redirect()->to(route('keranjang.index') . '#item-' . $id);
    }

    public function isiContoh()
    {
        $this->keranjang->isiContoh();

        return redirect()->route('keranjang.index');
    }
}