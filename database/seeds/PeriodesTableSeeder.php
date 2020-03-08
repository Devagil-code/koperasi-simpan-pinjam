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
        $periode->open_date = date('Y').'-01-01';
        $periode->close_date = date('Y').'-12-31';
        $periode->status = '1';
        $periode->save();
    }
}
