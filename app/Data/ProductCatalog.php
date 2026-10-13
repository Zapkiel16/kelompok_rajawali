<?php

namespace App\Data;

<<<<<<< HEAD
use App\Models\Produk;

/**
 * Sumber data produk dari tabel produks.
 * Format array dipertahankan agar DashboardController, DetailController,
 * dan MenuController yang sudah memakai ProductCatalog tetap kompatibel.
=======
/**
 * Sumber data produk tunggal (sementara, sebelum pindah ke database).
 * Dipakai oleh DashboardController dan DetailController supaya
 * nama, harga, dan ID selalu konsisten di kedua halaman.
>>>>>>> d118139c80da38a1f353785fb9656acd6f5102b9
 */
class ProductCatalog
{
    public const SNACK = 'snack';
<<<<<<< HEAD
    public const DRINK = 'drink';
    public const STOK_AWAL = 20;
    public const STOK_MENIPIS = 5;

    public static function all(): array
    {
        return Produk::query()->orderBy('id')->get()->mapWithKeys(function (Produk $produk) {
            return [$produk->id => self::format($produk)];
        })->all();
=======

    public const DRINK = 'drink';

    private const DESCRIPTION = 'Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et.';

    /**
     * Semua produk, key = ID produk (dipakai di URL /detail/{id}).
     */
    public static function all(): array
    {
        $rows = [
            // Makanan ringan
            1 => ['Item 1', 16000, self::SNACK],
            2 => ['Item 2', 12000, self::SNACK],
            3 => ['Item 3', 15000, self::SNACK],
            4 => ['Item 4', 10000, self::SNACK],
            5 => ['Item 5', 14000, self::SNACK],

            // Minuman
            6 => ['Drink 1', 5000, self::DRINK],
            7 => ['Drink 2', 7000, self::DRINK],
            8 => ['Drink 3', 12000, self::DRINK],
            9 => ['Drink 4', 15000, self::DRINK],
            10 => ['Drink 5', 13000, self::DRINK],
        ];

        $products = [];

        foreach ($rows as $id => [$name, $price, $type]) {
            $products[$id] = [
                'id' => $id,
                'name' => $name,
                'price' => $price,
                'type' => $type,
                'category' => $type === self::SNACK ? 'Makanan Ringan' : 'Minuman',
                'description' => self::DESCRIPTION,
                'image' => null,
                'stock' => 20,
            ];
        }

        return $products;
>>>>>>> d118139c80da38a1f353785fb9656acd6f5102b9
    }

    public static function find(int $id): ?array
    {
<<<<<<< HEAD
        $produk = Produk::find($id);
        return $produk ? self::format($produk) : null;
=======
        return self::all()[$id] ?? null;
>>>>>>> d118139c80da38a1f353785fb9656acd6f5102b9
    }

    public static function byType(string $type): array
    {
<<<<<<< HEAD
        return Produk::query()
            ->where('kategori', $type)
            ->orderBy('id')
            ->get()
            ->map(fn (Produk $produk) => self::format($produk))
            ->values()
            ->all();
    }

    private static function format(Produk $produk): array
    {
        return [
            'id' => (int) $produk->id,
            'name' => $produk->nama,
            'price' => (int) $produk->harga,
            'type' => $produk->kategori,
            'category' => $produk->kategori === self::SNACK ? 'Makanan Ringan' : 'Minuman',
            'description' => $produk->deskripsi ?? '',
            'image' => $produk->gambar ? '/storage/' . ltrim($produk->gambar, '/') : null,
            'stock' => (int) $produk->stok,
        ];
=======
        return array_values(array_filter(
            self::all(),
            fn (array $product) => $product['type'] === $type
        ));
>>>>>>> d118139c80da38a1f353785fb9656acd6f5102b9
    }
}
