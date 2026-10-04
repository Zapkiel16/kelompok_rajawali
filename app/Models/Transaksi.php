<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi extends Model
{
    protected $fillable = [
        'user_id',
        'nama_pemesan',
        'email_pemesan',
        'no_hp_pemesan',
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Tulisan status yang ditampilkan ke pembeli. Pembayaran dicek manual oleh penjual,
    // jadi status awal ("menunggu") ditampilkan sebagai "Pesanan diterima".
    protected function labelStatus(): Attribute
    {
        return Attribute::get(fn () => match ($this->status) {
            'dibayar' => 'Sudah dibayar',
            'dibatalkan' => 'Dibatalkan',
            default => 'Pesanan diterima',
        });
    }
}
