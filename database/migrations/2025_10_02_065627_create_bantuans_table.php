<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBantuansTable extends Migration
{
    public function up()
    {
        Schema::create('bantuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('jenis_bantuan');
            $table->integer('jumlah');
            $table->enum('status', ['Diproses', 'Dikirim'])->default('Diproses');
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bantuan');
    }
}