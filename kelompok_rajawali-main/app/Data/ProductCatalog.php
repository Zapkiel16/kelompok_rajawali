<?php

namespace App\Data;

use App\Models\Produk;

class ProductCatalog
{
    public const SNACK = 'snack';
    public const DRINK = 'drink';

    public const STOK_AWAL = 20;
    public const STOK_MENIPIS = 5;

    public static function all(): array
    {
        return Produk::query()
            ->orderBy('id')
            ->get()
            ->map(fn (Produk $p) => [
                'id' => $p->id,
                'name' => $p->nama_produk,
                'price' => (int) $p->harga,
                'type' => $p->kategori,
                'category' => $p->kategori === self::SNACK
                    ? 'Makanan Ringan'
                    : 'Minuman',
                'description' => $p->deskripsi ?? '',
                'image' => $p->gambar
                    ? asset('storage/' . $p->gambar)
                    : null,
                'stock' => (int) $p->stok,
            ])
            ->keyBy('id')
            ->all();
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
