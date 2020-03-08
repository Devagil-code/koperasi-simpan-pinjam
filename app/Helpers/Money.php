<?php

namespace App\Helpers;

class Money {

    public static function rupiahToString($rp)
    {
        $result = substr(str_replace(".", "", $rp), 3);
        return $result;
    }

    public static function stringToRupiah($rp)
    {
        return 'Rp. ' . number_format($rp, 0, '', '.');
    }
}
