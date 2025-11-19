<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'petani', 'petugas'])->default('petani')->after('password');
            $table->string('alamat_desa')->nullable()->after('role');
            $table->integer('luas_lahan')->nullable()->after('alamat_desa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'alamat_desa', 'luas_lahan']);
        });
    }
};
