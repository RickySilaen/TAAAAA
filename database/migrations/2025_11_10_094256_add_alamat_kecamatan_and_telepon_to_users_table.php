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
            // Cek apakah kolom belum ada sebelum menambahkan
            if (!Schema::hasColumn('users', 'alamat_kecamatan')) {
                $table->string('alamat_kecamatan')->nullable()->after('alamat_desa');
            }
            if (!Schema::hasColumn('users', 'telepon')) {
                $table->string('telepon', 20)->nullable()->after('email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['alamat_kecamatan', 'telepon']);
        });
    }
};
