<?php

namespace App\Services;

/**
 * Kode promo yang sedang dipakai (disimpan di session), dipakai bersama oleh halaman keranjang dan checkout.
 */
class Promo
{
    private const KUNCI = 'promo_aktif';

    // Daftar kode promo contoh. Nanti bisa dipindah ke tabel database kalau mau dikelola dari admin.
    public function daftar(): array
    {
        return [
            'SNACK10'   => ['tipe' => 'persen', 'nilai' => 10],    // potongan 10%
            'HEMAT5000' => ['tipe' => 'nominal', 'nilai' => 5000], // potongan Rp 5.000
        ];
    }

    /** Pasang kode promo. Mengembalikan kode yang dipakai, atau null kalau kodenya tidak ada. */
    public function terapkan(string $kode): ?string
    {
        $kode = strtoupper(trim($kode));
        $daftar = $this->daftar();

        if (!isset($daftar[$kode])) {
            return null;
        }

        session([self::KUNCI => array_merge($daftar[$kode], ['kode' => $kode])]);

        return $kode;
    }

    public function aktif(): ?array
    {
        return session(self::KUNCI);
    }

    public function hapus(): void
    {
        session()->forget(self::KUNCI);
    }

    public function diskon(int $totalHarga): int
    {
        $promo = $this->aktif();
        if (!$promo) {
            return 0;
        }

        if ($promo['tipe'] === 'persen') {
            return (int) round($totalHarga * $promo['nilai'] / 100);
        }

        return min($promo['nilai'], $totalHarga); // diskon nominal nggak boleh lebih besar dari totalnya
    }
}