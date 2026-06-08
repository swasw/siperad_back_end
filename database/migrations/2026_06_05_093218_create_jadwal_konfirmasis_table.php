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
        Schema::create('jadwal_konfirmasis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jadwal_ruangan_id');
            $table->date('tanggal');
            $table->enum('status', ['pending', 'dilaksanakan', 'tidak_dilaksanakan'])->default('pending');
            $table->timestamp('waktu_konfirmasi')->nullable();
            $table->timestamps();

            $table->foreign('jadwal_ruangan_id')->references('id')->on('jadwal_ruangans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_konfirmasis');
    }
};
