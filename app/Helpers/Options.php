<?php

namespace App\Helpers;

use App\Option;

class Options {

    public static function show($param)
    {
        $option = Option::select()->where('option_name', $param)->first();
        return $option->option_value;
    }
}
