<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBantuansTable extends Migration
{
    public function up()
    {
        Schema::create('bantuans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('jenis_bantuan');
            $table->integer('jumlah');
            $table->string('status')->default('pending');
            $table->date('tanggal')->nullable();
            $table->date('tanggal_permintaan')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bantuans');
    }
}
