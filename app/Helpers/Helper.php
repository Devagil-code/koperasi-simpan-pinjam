<?php

use App\Option;
use App\Periode;

function set_active($uri, $output = 'active')
{
    if (is_array($uri)) {
        foreach ($uri as $u) {
            if (Route::is($u)) {
                return $output;
            }
        }
    } else {
        if (Route::is($uri)) {
            return $output;
        }
    }
}

/**
 * menambahkan class open pada link
 * @param [uri] $uri Current URI
 * @param string $output CSS class name.
 */
function set_open($uri, $output = 'open')
{
    if (is_array($uri)) {
        foreach ($uri as $u) {
            if (Route::is($u)) {
                return $output;
            }
        }
    } else {
        if (Route::is($uri)) {
            return $output;
        }
    }
}
if (!function_exists('periode')) {
    function periode()
    {
        $periode = Periode::where('status', 1)->first();
        return $periode;
    }
}
