<?php

use Illuminate\Database\Seeder;
use App\Option;

class OptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $option = new Option();
        $option->option_name = 'footer';
        $option->option_value = 'Koperasi V2.0';
        $option->save();

        $option = new Option();
        $option->option_name = "company_name";
        $option->option_value = "Koperasi Maju Mundur";
        $option->save();

        $option = new Option();
        $option->option_name = 'company_address';
        $option->option_value = 'Jalan Malaka Baru RT 01 RW 011 Pondok Kopi Jakarta Timur';
        $option->save();

        $option = new Option();
        $option->option_name = 'company_telp';
        $option->option_value = '021-86615842';
        $option->save();

        $option = new Option();
        $option->option_name = 'company_fax';
        $option->option_value = '021-86615842';
        $option->save();
    }
}
