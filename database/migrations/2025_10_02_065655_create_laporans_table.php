<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('jenis_tanaman');
            $table->decimal('hasil_panen', 10, 2);
            $table->decimal('luas_panen', 8, 2)->nullable();
            $table->decimal('luas_lahan', 8, 2)->nullable();
            $table->text('deskripsi_kemajuan')->nullable();
            $table->date('tanggal')->nullable();
            $table->date('tanggal_panen')->nullable();
            $table->text('catatan')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
