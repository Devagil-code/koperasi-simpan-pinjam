<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaksiHarianAnggotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_harian_anggotas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('transaksi_harian_id')->unsigned()->nullable();
            $table->bigInteger('anggota_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('transaksi_harian_id')->references('id')->on('transaksi_harians');
            $table->foreign('anggota_id')->references('id')->on('anggotas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_harian_anggotas');
    }
}
