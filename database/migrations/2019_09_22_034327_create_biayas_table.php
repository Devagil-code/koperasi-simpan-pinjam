<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiayasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biayas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->bigInteger('divisi_id')->unsigned();
            $table->boolean('jenis_biaya');
            $table->timestamps();
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
        Schema::dropIfExists('biayas');
    }
}
