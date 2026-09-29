<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'items',
        'total_harga',
        'total_diskon',
        'total_tagihan',
        'metode',
        'status',
    ];

    protected $casts = [
        'items' => 'array',
    ];
}