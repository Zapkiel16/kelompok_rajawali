<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    // Halaman konfirmasi "Keluar dari akun?"
    public function konfirmasi()
    {
        return view('logout');
    }

    public function keluar(Request $request)
    {
        Auth::guard('web')->logout();

        // Hapus seluruh session (termasuk keranjang) dan buat token CSRF baru
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('masuk');
    }
}