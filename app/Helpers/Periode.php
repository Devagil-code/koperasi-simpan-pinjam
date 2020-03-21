<?php

namespace App\Helpers;

class Periode {

    public static function tanggal_id($tgl)
    {
        $dt = new Carbon($tgl);
        setlocale(LC_TIME, 'IND');
        setlocale(LC_TIME, 'id_ID');
        return $dt->formatLocalized('%d %B %Y');
    }
}