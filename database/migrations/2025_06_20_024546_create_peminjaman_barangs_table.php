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
        Schema::create('peminjaman_barangs', function (Blueprint $table) {
            $table->id();
            $table->date('tgl_peminjaman');
            $table->string('nama_peminjam');
            $table->string('nim');
            $table->string('no_hp');
            $table->unsignedBigInteger('prodi_id');
            $table->unsignedBigInteger('angkatan_id');
            $table->unsignedBigInteger('matkul_id');
            $table->unsignedBigInteger('dosen_id');
            $table->unsignedBigInteger('barang_id');
            $table->boolean('status_peminjaman')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_barangs');
    }
};
