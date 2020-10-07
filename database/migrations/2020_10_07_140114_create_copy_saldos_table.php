<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCopySaldosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('copy_saldos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('from_periode_id');
            $table->unsignedBigInteger('to_periode_id');
            $table->unsignedBigInteger('divisi_id');
            $table->boolean('status_saldo');
            $table->timestamps();

            $table->foreign('from_periode_id')->references('id')->on('periodes');
            $table->foreign('to_periode_id')->references('id')->on('periodes');
            $table->foreign('divisi_id')->references('id')->on('divisis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('copy_saldos');
    }
}
