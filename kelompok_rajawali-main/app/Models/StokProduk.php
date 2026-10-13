<?php

namespace App\Models;

use Database\Factories\StokProdukFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Stok yang diatur admin. Satu baris per produk di ProductCatalog;
 * produk yang belum punya baris memakai ProductCatalog::STOK_AWAL.
 */
class StokProduk extends Model
{
    /** @use HasFactory<StokProdukFactory> */
    use HasFactory;

    protected $fillable = ['produk_id', 'stok'];
}