<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    //

    protected $fillable = [
        'option_name',
        'option_value',
        'option_type'
    ];
}
