<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPeriodeIdToTransaksiHarian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaksi_harians', function (Blueprint $table) {
            //
            $table->bigInteger('periode_id')->unsigned()->nullable();
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
        Schema::table('transaksi_harians', function (Blueprint $table) {
            //
        });
    }
}
