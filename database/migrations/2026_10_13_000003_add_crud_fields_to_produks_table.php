<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Migration ini aman untuk tabel produks yang sudah ada.
        Schema::table('produks', function (Blueprint $table) {
            if (!Schema::hasColumn('produks', 'nama')) {
                $table->string('nama')->default('Produk');
            }
            if (!Schema::hasColumn('produks', 'kategori')) {
                $table->string('kategori')->default('snack');
            }
            if (!Schema::hasColumn('produks', 'harga')) {
                $table->unsignedInteger('harga')->default(0);
            }
            if (!Schema::hasColumn('produks', 'deskripsi')) {
                $table->text('deskripsi')->nullable();
            }
            if (!Schema::hasColumn('produks', 'gambar')) {
                $table->string('gambar')->nullable();
            }
            if (!Schema::hasColumn('produks', 'stok')) {
                $table->unsignedInteger('stok')->default(0);
            }
        });
    }

    public function down(): void
    {
        // Tidak menghapus kolom agar data pengguna tetap aman.
    }
};
