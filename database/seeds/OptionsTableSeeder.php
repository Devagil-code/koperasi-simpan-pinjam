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

        // $option = new Option();
        // $option->option_name = "company_name";
        // $option->option_value = "Koperasi Maju Mundur";
        // $option->save();

        // $option = new Option();
        // $option->option_name = 'company_address';
        // $option->option_value = 'Jalan Malaka Baru RT 01 RW 011 Pondok Kopi Jakarta Timur';
        // $option->save();

        // $option = new Option();
        // $option->option_name = 'company_telp';
        // $option->option_value = '021-86615842';
        // $option->save();

        // $option = new Option();
        // $option->option_name = 'company_fax';
        // $option->option_value = '021-86615842';
        // $option->save();

        //
        $option = new Option();
        $option->option_name = 'title_text';
        $option->option_value = 'KOPERASI MAJU';
        $option->save();

        $option = new Option();
        $option->option_name = 'footer_text';
        $option->option_value = 'KOPERASI MUNDUR';
        $option->save();

        $option = new Option();
        $option->option_name = 'site_currency_symbol';
        $option->option_value = 'Rp ';
        $option->save();

        $option = new Option();
        $option->option_name = 'company_option_name';
        $option->option_value = 'KOPERASI MAJU MUNDUR';
        $option->save();

        $option = new Option();
        $option->option_name = 'company_address';
        $option->option_value = 'Jalan Malaka Baru RT 01 RW 011 Pondok Kopi Jakarta Timur';
        $option->save();

        $option = new Option();
        $option->option_name = 'company_phone';
        $option->option_value = '021-86615842';
        $option->save();

        $option = new Option();
        $option->option_name = 'company_email';
        $option->option_value = 'koperasi_maju@mundur.com';
        $option->save();

        $option = new Option();
        $option->option_name = 'postal_code';
        $option->option_value = '17414';
        $option->save();

        $option = new Option();
        $option->option_name = 'company_fb';
        $option->option_value = 'facebook.com';
        $option->save();

        $option = new Option();
        $option->option_name = 'company_ig';
        $option->option_value = 'instagram.com';
        $option->save();

        $option = new Option();
        $option->option_name = 'company_twitter';
        $option->option_value = 'twitter.com';
        $option->save();

        $option = new Option();
        $option->option_name = 'company_yt';
        $option->option_value = 'youtube.com';
        $option->save();

        $option = new Option();
        $option->option_name = 'phone_wa';
        $option->option_value = '+62 857-7909-0815';
        $option->save();

        $option = new Option();
        $option->option_name = 'text_wa';
        $option->option_value = 'Hallo, KOPERASI MAJU MUNDUR, Saya Dapat Info dari Website';
        $option->save();

        $option = new Option();
        $option->option_name = 'text_maintenance';
        $option->option_value = 'Hallo, KOPERASI MAJU MUNDUR, Saat Ini Sedang Maintenance';
        $option->save();
    }
}
