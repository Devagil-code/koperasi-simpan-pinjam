<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaksiPinjamenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_pinjamen', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('transaksi_harian_biaya_id')->unsigned();
            $table->integer('lama_cicilan');
            $table->timestamps();

            $table->foreign('transaksi_harian_biaya_id')->references('id')->on('transaksi_harian_biayas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_pinjamen');
    }
}
