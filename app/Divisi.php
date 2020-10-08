<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    //
    protected $fillable = [
        'name'
    ];

    public function copy_saldo()
    {
        return $this->hasMany('App\CopySaldo');
    }
}
