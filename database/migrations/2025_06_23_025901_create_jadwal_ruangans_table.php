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
        Schema::create('jadwal_ruangans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ruang_id');
            $table->unsignedBigInteger('matkul_id');
            $table->unsignedBigInteger('dosen_id');
            $table->string('hari');
            $table->unsignedBigInteger('jam_mulai_id');
            $table->unsignedBigInteger('jam_selesai_id');
            $table->unsignedBigInteger('prodi_id');
            $table->unsignedBigInteger('angkatan_id');
            $table->boolean('status_ruang')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_ruangans');
    }
};
