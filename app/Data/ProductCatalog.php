<?php

namespace App\Data;

/**
 * Sumber data produk tunggal (sementara, sebelum pindah ke database).
 * Dipakai oleh DashboardController dan DetailController supaya
 * nama, harga, dan ID selalu konsisten di kedua halaman.
 */
class ProductCatalog
{
    public const SNACK = 'snack';

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
    }

    public static function find(int $id): ?array
    {
        return self::all()[$id] ?? null;
    }

    public static function byType(string $type): array
    {
        return array_values(array_filter(
            self::all(),
            fn (array $product) => $product['type'] === $type
        ));
    }
}
