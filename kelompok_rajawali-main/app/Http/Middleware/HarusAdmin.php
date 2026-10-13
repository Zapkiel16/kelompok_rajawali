<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Halaman admin hanya untuk akun yang login dan bertanda admin.
 * Pengunjung/tamu diarahkan ke halaman masuk, akun biasa ditolak (403).
 */
class HarusAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (! auth()->check()) {
            return redirect()->route('masuk')->with('pesan', 'Masuk dengan akun admin dulu ya.');
        }

        abort_unless(auth()->user()->adalahAdmin(), 403, 'Halaman ini khusus admin.');

        return $next($request);
    }
}
