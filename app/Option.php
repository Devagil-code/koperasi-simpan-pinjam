<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Option extends Model
{
    //
    protected $table = 'options';

    //
    public static function options()
    {
        $data = DB::table('options');
        $data = $data->get();

        $options = [
            "site_currency_symbol" => "Rp ",
            "company_name" => "KOPERASI",
            "company_address" => "Jalan Malaka Baru RT 01 RW 011 Pondok Kopi Jakarta Timur",
            "company_phone" => "",
            "company_email" => "",
            "postal_code" => "",
            "company_fb" => "",
            "company_ig" => "",
            "company_twitter" => "",
            "company_yt" => "",
            "phone_wa" => "",
            "text_wa" => ""
        ];

        foreach ($data as $row) {
            $options[$row->option_name] = $row->option_value;
        }

        return $options;
    }

    //
    public static function getValByName($key)
    {
        $option = Option::options();
        if (!isset($option[$key]) || empty($option[$key])) {
            $option[$key] = '';
        }
        return $option[$key];
    }

    public static function setEnvironmentValue(array $values)
    {
        $envFile = app()->environmentFilePath();
        $str     = file_get_contents($envFile);
        if (count($values) > 0) {
            foreach ($values as $envKey => $envValue) {
                $keyPosition       = strpos($str, "{$envKey}=");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine           = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
                // If key does not exist, add it
                if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                    $str .= "{$envKey}='{$envValue}'\n";
                } else {
                    $str = str_replace($oldLine, "{$envKey}='{$envValue}'", $str);
                }
            }
        }
        $str = substr($str, 0, -1);
        $str .= "\n";
        if (!file_put_contents($envFile, $str)) {
            return false;
        }

        return true;
    }
}
