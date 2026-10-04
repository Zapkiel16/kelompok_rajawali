<?php

namespace App\Services;

use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Support\Collection;

/**
 * Siapa yang sedang belanja: akun yang login, atau tamu (guest) yang sudah mengisi biodata.
 * Pesanan tamu dicatat di session, jadi hanya bisa dilihat dari browser yang sama.
 */
class Pemesan
{
    public function ada(): bool
    {
        return auth()->check() || session()->has('tamu');
    }

    /** Data pemesan untuk disimpan di transaksi, atau null kalau belum login / belum isi biodata tamu. */
    public function data(): ?array
    {
        if (auth()->check()) {
            $user = auth()->user();

            return ['user_id' => $user->id, 'nama' => $user->name, 'email' => $user->email, 'no_hp' => $user->no_hp];
        }

        $tamu = session('tamu');

        return $tamu ? ['user_id' => null, 'nama' => $tamu['nama'], 'email' => $tamu['email'], 'no_hp' => $tamu['no_hp']] : null;
    }

    /** Catat pesanan tamu di session supaya bisa dilihat lagi. Pesanan akun sudah tercatat lewat user_id. */
    public function catatTransaksi(Transaksi $transaksi): void
    {
        if (auth()->check()) {
            return;
        }

        $ids = session('transaksi_tamu', []);
        $ids[] = $transaksi->id;
        session(['transaksi_tamu' => array_values(array_unique($ids))]);
    }

    public function bolehMelihat(Transaksi $transaksi): bool
    {
        if (auth()->check()) {
            return $transaksi->user_id !== null && (int) $transaksi->user_id === (int) auth()->id();
        }

        return $transaksi->user_id === null && in_array($transaksi->id, session('transaksi_tamu', []), true);
    }

    public function daftarTransaksi(): Collection
    {
        if (auth()->check()) {
            return Transaksi::where('user_id', auth()->id())->latest('id')->get();
        }

        $ids = session('transaksi_tamu', []);

        return $ids === [] ? collect() : Transaksi::whereNull('user_id')->whereIn('id', $ids)->latest('id')->get();
    }

    /** Setelah login/daftar, pesanan yang dibuat sebagai tamu di browser ini dipindahkan ke akunnya. */
    public function klaimPesananTamu(User $user): void
    {
        $ids = session('transaksi_tamu', []);

        if ($ids !== []) {
            Transaksi::whereNull('user_id')->whereIn('id', $ids)->update(['user_id' => $user->id]);
        }

        session()->forget(['transaksi_tamu', 'tamu']);
    }
}
