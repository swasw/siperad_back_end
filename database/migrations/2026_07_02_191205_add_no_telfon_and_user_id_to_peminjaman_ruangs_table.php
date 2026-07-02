<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('peminjaman_ruangs', function (Blueprint $table) {
            $table->string('no_telfon')->nullable()->after('nama_peminjam');
            $table->unsignedBigInteger('user_id')->nullable()->after('no_telfon');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjaman_ruangs', function (Blueprint $table) {
            $table->dropColumn(['no_telfon', 'user_id']);
        });
    }
};
