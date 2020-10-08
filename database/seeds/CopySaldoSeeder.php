<?php

use App\CopySaldo;
use Illuminate\Database\Seeder;

class CopySaldoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $copy_saldo = new CopySaldo();
        $copy_saldo->from_periode_id = '1';
        $copy_saldo->to_periode_id = '2';
        $copy_saldo->divisi_id = '1';
        $copy_saldo->status_saldo = '0';
        $copy_saldo->save();

        $copy_saldo = new CopySaldo();
        $copy_saldo->from_periode_id = '1';
        $copy_saldo->to_periode_id = '2';
        $copy_saldo->divisi_id = '2';
        $copy_saldo->status_saldo = '0';
        $copy_saldo->save();
    }
}
