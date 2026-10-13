<?php

namespace App\Http\Middleware;

use App\Services\Pemesan;
use Closure;
use Illuminate\Http\Request;

/**
 * Dashboard, detail produk, keranjang, checkout & pesanan hanya untuk akun yang login
 * atau tamu yang sudah isi biodata. Kalau belum, diarahkan ke halaman masuk.
 * Setelah login selalu balik ke dashboard menu utama, bukan ke halaman yang dituju tadi.
 */
class HarusAdaPemesan
{
    public function __construct(private Pemesan $pemesan)
    {
    }

    public function handle(Request $request, Closure $next)
    {
        if ($this->pemesan->ada()) {
            return $next($request);
        }

        $arahkan = redirect()->route('masuk');

        // Pengunjung yang baru membuka situs (halaman utama) tidak perlu diberi pesan
        if (! $request->is('/')) {
            $arahkan->with('pesan', 'Masuk atau lanjut sebagai tamu dulu ya.');
        }

        return $arahkan;
    }
}