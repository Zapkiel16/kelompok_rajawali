<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // user_id kosong = pesanan dari tamu (guest)
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
            $table->string('nama_pemesan')->nullable()->after('user_id');
            $table->string('email_pemesan')->nullable()->after('nama_pemesan');
            $table->string('no_hp_pemesan', 20)->nullable()->after('email_pemesan');
        });
    }

    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
            $table->dropColumn(['nama_pemesan', 'email_pemesan', 'no_hp_pemesan']);
        });
    }
};
