<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaksiHarianBiayasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_harian_biayas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('transaksi_harian_id')->unsigned()->nullable();
            $table->bigInteger('biaya_id')->unsigned()->nullable();
            $table->decimal('nominal', 10)->nullable();
            $table->timestamps();

            $table->foreign('transaksi_harian_id')->references('id')->on('transaksi_harians');
            $table->foreign('biaya_id')->references('id')->on('biayas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_harian_biayas');
    }
}
