<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->json('items');            // isi barang yang dibeli (nama, harga, jumlah)
            $table->unsignedBigInteger('total_harga');
            $table->unsignedBigInteger('total_diskon')->default(0);
            $table->unsignedBigInteger('total_tagihan');
            $table->string('metode');         // QRIS atau Cash
            $table->string('status')->default('menunggu'); // menunggu, dibayar, dibatalkan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};