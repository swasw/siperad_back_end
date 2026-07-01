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
        Schema::table('jadwal_konfirmasis', function (Blueprint $table) {
            $table->unique(['jadwal_ruangan_id', 'tanggal'], 'unique_konfirmasi_per_jadwal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_konfirmasis', function (Blueprint $table) {
            $table->dropUnique('unique_konfirmasi_per_jadwal');
        });
    }
};
