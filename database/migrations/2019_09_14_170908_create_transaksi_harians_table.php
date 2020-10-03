<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaksiHariansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_harians', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('divisi_id')->unsigned()->nullable();
            $table->date('tgl');
            $table->integer('jenis_pembayaran');
            $table->integer('jenis_transaksi');
            $table->text('keterangan')->nullable();
            $table->bigInteger('periode_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('divisi_id')->references('id')->on('divisis');
            $table->foreign('periode_id')->references('id')->on('periodes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_harians');
    }
}
