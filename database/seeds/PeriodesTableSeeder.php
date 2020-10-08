<?php

use Illuminate\Database\Seeder;
use App\Periode;

class PeriodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $periode = new Periode();
        $periode->name = date('Y');
        $periode->open_date = date('Y') . '-01-01';
        $periode->close_date = date('Y') . '-12-31';
        $periode->status = '1';
        $periode->save();

        $periode = new Periode();
        $periode->name = '2021';
        $periode->open_date = '2021-01-01';
        $periode->close_date = '2021-12-31';
        $periode->status = '0';
        $periode->save();
    }
}
