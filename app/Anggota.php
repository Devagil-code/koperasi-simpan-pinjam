<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    //

    protected $fillable = [
        'nama',
        'nik',
        'inisial',
        'tgl_daftar',
        'status',
        'homebase'
    ];
}
