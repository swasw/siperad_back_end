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
        Schema::table('users', function (Blueprint $table) {
            $table->string('no_telfon')->nullable()->after('password');
            $table->unsignedBigInteger('prodi_id')->nullable()->change();
            $table->unsignedBigInteger('angkatan_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('no_telfon');
            $table->unsignedBigInteger('prodi_id')->nullable(false)->change();
            $table->unsignedBigInteger('angkatan_id')->nullable(false)->change();
        });
    }
};
