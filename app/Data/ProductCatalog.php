<?php

namespace App\Data;

use App\Models\Produk;

/**
 * Sumber data produk dari tabel produks.
 * Format array dipertahankan agar DashboardController, DetailController,
 * dan MenuController yang sudah memakai ProductCatalog tetap kompatibel.
 */
class ProductCatalog
{
    public const SNACK = 'snack';
    public const DRINK = 'drink';
    public const STOK_AWAL = 20;
    public const STOK_MENIPIS = 5;

    public static function all(): array
    {
        return Produk::query()->orderBy('id')->get()->mapWithKeys(function (Produk $produk) {
            return [$produk->id => self::format($produk)];
        })->all();
    }

    public static function find(int $id): ?array
    {
        $produk = Produk::find($id);
        return $produk ? self::format($produk) : null;
    }

    public static function byType(string $type): array
    {
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
    }
}
