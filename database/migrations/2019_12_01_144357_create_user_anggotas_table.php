<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAnggotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_anggotas', function (Blueprint $table) {
            $table->bigInteger('anggota_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('anggota_id')->references('id')->on('anggotas')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['user_id', 'anggota_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_anggotas');
    }
}
