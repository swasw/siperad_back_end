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
        Schema::create('peminjaman_ruangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_peminjam');
            $table->date('tgl_peminjaman');
            $table->unsignedBigInteger('matkul_id');
            $table->unsignedBigInteger('jam_mulai_id');
            $table->unsignedBigInteger('jam_selesai_id');
            $table->unsignedBigInteger('dosen_id');
            $table->unsignedBigInteger('ruang_id');
            $table->unsignedBigInteger('prodi_id');
            $table->unsignedBigInteger('angkatan_id');
            $table->boolean('status_peminjaman')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_ruangs');
    }
};
