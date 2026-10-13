<?php

namespace App\Services;

class Keranjang
{
    private const KUNCI = 'keranjang';
    private const JUMLAH_MAKS = 99;

    public function semua(): array
    {
        // Keranjang awalnya kosong, baru terisi kalau pengunjung menambah dari menu
        if (!session()->has(self::KUNCI)) {
            $this->simpan([]);
        }

        return session(self::KUNCI);
    }

    public function terpilih(): array
    {
        return array_values(array_filter($this->semua(), fn (array $item) => $item['dipilih']));
    }

    /** Hitung jumlah barang & total harga dari daftar item yang diberikan. */
    public function ringkasan(array $items): array
    {
        $barang = 0;
        $harga = 0;
        foreach ($items as $item) {
            $barang += $item['jumlah'];
            $harga += $item['harga'] * $item['jumlah'];
        }

        return ['barang' => $barang, 'harga' => $harga];
    }

    /** Dipanggil dari halaman menu untuk menambah ke keranjang. */
    public function tambah(string $nama, int $harga, int $jumlah = 1): void
    {
        $items = $this->semua();

        foreach ($items as $i => $item) {
            if ($item['nama'] === $nama) {
                $items[$i]['jumlah'] = min(self::JUMLAH_MAKS, $item['jumlah'] + $jumlah);
                $this->simpan($items);

                return;
            }
        }

        $items[] = [
            'id' => $this->idBerikutnya($items),
            'nama' => $nama,
            'harga' => $harga,
            'jumlah' => max(1, min(self::JUMLAH_MAKS, $jumlah)),
            'catatan' => '',
            'dipilih' => true,
        ];
        $this->simpan($items);
    }

    public function ubahJumlah(int $id, int $selisih): void
    {
        $this->simpan(array_map(function (array $item) use ($id, $selisih) {
            if ($item['id'] === $id) {
                $item['jumlah'] = max(1, min(self::JUMLAH_MAKS, $item['jumlah'] + $selisih));
            }

            return $item;
        }, $this->semua()));
    }

    public function hapus(int $id): void
    {
        $this->simpan(array_values(array_filter($this->semua(), fn (array $item) => $item['id'] !== $id)));
    }

    /** Hapus item yang sudah dibeli (yang dicentang), item lain tetap di keranjang. */
    public function hapusTerpilih(): void
    {
        $this->simpan(array_values(array_filter($this->semua(), fn (array $item) => !$item['dipilih'])));
    }

    /** Simpan status centang dan catatan dari form keranjang. */
    public function sinkron(array $dipilih, array $catatan): void
    {
        $dipilih = array_map('intval', $dipilih);

        $this->simpan(array_map(function (array $item) use ($dipilih, $catatan) {
            $item['dipilih'] = in_array($item['id'], $dipilih, true);
            if (array_key_exists($item['id'], $catatan)) {
                $item['catatan'] = trim((string) $catatan[$item['id']]);
            }

            return $item;
        }, $this->semua()));
    }

    /** Simpan catatan saja (dipakai halaman checkout). Kunci array = id item. */
    public function simpanCatatan(array $catatan): void
    {
        $this->simpan(array_map(function (array $item) use ($catatan) {
            if (array_key_exists($item['id'], $catatan)) {
                $item['catatan'] = trim((string) $catatan[$item['id']]);
            }

            return $item;
        }, $this->semua()));
    }

    /** Data contoh, hanya dipakai kalau tombol "produk contoh" di keranjang kosong ditekan. */
    public function isiContoh(): void
    {
        $this->simpan([
            ['id' => 1, 'nama' => 'Superstar Jumbo Triple Coklat Banget', 'harga' => 5000, 'jumlah' => 1, 'catatan' => '', 'dipilih' => true],
            ['id' => 2, 'nama' => 'Pop Mie Enak Mantap Super Pedas', 'harga' => 6000, 'jumlah' => 1, 'catatan' => '', 'dipilih' => false],
            ['id' => 3, 'nama' => 'Kue Lapis Khas Ngawi Tumpuk Banyak', 'harga' => 3000, 'jumlah' => 1, 'catatan' => '', 'dipilih' => true],
            ['id' => 4, 'nama' => 'Roti O asli Stasiun Lempuyangan Manis', 'harga' => 7000, 'jumlah' => 1, 'catatan' => '', 'dipilih' => false],
        ]);
    }

    private function simpan(array $items): void
    {
        session([self::KUNCI => $items]);
    }

    private function idBerikutnya(array $items): int
    {
        return $items === [] ? 1 : max(array_column($items, 'id')) + 1;
    }
}