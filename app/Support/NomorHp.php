<?php

namespace App\Support;

class NomorHp
{
    /** Samakan format nomor HP: hanya angka, diawali 0 (misal +62 812-3456-7890 menjadi 081234567890). */
    public static function normalisasi(?string $hp): string
    {
        $angka = preg_replace('/\D+/', '', (string) $hp);

        if (str_starts_with($angka, '62')) {
            return '0' . substr($angka, 2);
        }

        if (str_starts_with($angka, '8')) {
            return '0' . $angka;
        }

        return $angka;
    }
}
