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
        Schema::create('prodis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_prodi')->unique();;
            $table->timestamps();
        });

        Schema::create('angkatans', function (Blueprint $table) {
            $table->id();
            $table->string('angkatan')->unique();;
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedBigInteger('prodi_id');
            $table->unsignedBigInteger('angkatan_id');
            $table->tinyInteger('type')->default(0);
            $table->rememberToken();
            $table->timestamps();
            // $table->foreign('prodi_id')->references('id')->on('prodis')->onDelete('cascade');
            // $table->foreign('angkatan_id')->references('id')->on('angkatans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('angkatans');
        Schema::dropIfExists('prodis');
    }
};
