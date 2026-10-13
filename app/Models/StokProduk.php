<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokProduk extends Model
{
    use HasFactory;

    protected $table = 'stok_produks';

    protected $fillable = [
        'produk_id',
        'stok',
    ];

    protected $casts = [
        'produk_id' => 'integer',
        'stok' => 'integer',
    ];
}
