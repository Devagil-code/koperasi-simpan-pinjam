<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    //

    public function permission()
    {
        return $this->hasMany('App\Permission');
    }
}
