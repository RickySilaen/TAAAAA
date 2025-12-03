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
        Schema::create('laporan_bantuans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('bantuan_id')->nullable()->constrained('bantuans')->onDelete('set null');

            // Informasi Laporan
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('jenis_bantuan'); // pupuk, bibit, alat, dll
            $table->decimal('jumlah_bantuan', 10, 2)->nullable();
            $table->string('satuan')->nullable(); // kg, ton, unit, dll

            // Foto Bukti (multiple photos support)
            $table->json('foto_bukti'); // Array of photo paths

            // Lokasi
            $table->string('alamat_desa')->nullable();
            $table->string('alamat_kecamatan')->nullable();
            $table->string('koordinat')->nullable(); // lat,long

            // Status dan Validasi
            $table->enum('status', ['pending', 'verified', 'rejected', 'published'])->default('pending');
            $table->text('catatan_verifikasi')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();

            // Transparansi
            $table->boolean('is_public')->default(true); // Tampil di dashboard publik
            $table->integer('views_count')->default(0);

            // Tanggal
            $table->date('tanggal_penerimaan')->nullable();
            $table->date('tanggal_pelaporan')->default(now());

            $table->timestamps();
            $table->softDeletes();

            // Indexes untuk performa
            $table->index('status');
            $table->index('is_public');
            $table->index('tanggal_pelaporan');
            $table->index('jenis_bantuan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_bantuans');
    }
};
