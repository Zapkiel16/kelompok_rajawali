<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'no_hp', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Admin dibuat lewat AdminSeeder, bukan lewat pendaftaran,
     * jadi is_admin sengaja tidak termasuk kolom yang boleh diisi massal.
     *
     * (bool) dipakai karena is_admin bisa bernilai null pada model yang
     * baru dibuat (misalnya lewat factory) dan belum di-refresh dari database.
     */
    public function adalahAdmin(): bool
    {
        return (bool) $this->is_admin;
    }
}