<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ChangeLengthNominalToTransaksiHarianBiaya extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaksi_harian_biayas', function (Blueprint $table) {
            //
            DB::statement('ALTER TABLE transaksi_harian_biayas MODIFY COLUMN nominal DECIMAL(65)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaksi_harian_biayas', function (Blueprint $table) {
            //
        });
    }
}
