<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Buat (atau perbarui) akun admin dari config/admin.php.
     * Aman dijalankan berulang: email yang sama tidak dobel.
     */
    public function run(): void
    {
        $admin = User::firstOrNew(['email' => config('admin.email')]);

        // forceFill karena is_admin sengaja tidak boleh diisi massal
        $admin->forceFill([
            'name' => config('admin.nama'),
            'password' => config('admin.password'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ])->save();
    }
}
