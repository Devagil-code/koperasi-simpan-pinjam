<?php

namespace App\Helpers;

use Carbon\Carbon;

class Tanggal {

    public static function tanggal_id($tgl)
    {
        $dt = new Carbon($tgl);
        setlocale(LC_TIME, 'IND');
        setlocale(LC_TIME, 'id_ID');
        return $dt->formatLocalized('%d %B %Y');
    }

    public static function convert_tanggal($tgl)
    {
        return date('Y-m-d', strtotime($tgl));
    }

    public static function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return \Carbon\Carbon::createFromFormat($format, $value);
        }
    }
}
