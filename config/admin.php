<?php

/*
| Akun admin yang dibuat oleh AdminSeeder.
| Diisi lewat .env supaya password tidak tertulis di kode.
*/
return [
    'nama' => env('ADMIN_NAMA', 'Admin SnackinAja'),
    'email' => env('ADMIN_EMAIL', 'admin@snackinaja.test'),
    'password' => env('ADMIN_PASSWORD', 'ganti-password-ini'),
];
