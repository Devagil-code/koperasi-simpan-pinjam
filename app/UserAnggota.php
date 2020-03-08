<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAnggota extends Model
{
    //
    protected $fillable = [
        'user_id',
        'anggota_id'
    ];

    public $timestamps = false;
}
