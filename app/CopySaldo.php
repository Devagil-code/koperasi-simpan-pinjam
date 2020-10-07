<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CopySaldo extends Model
{
    protected $table = 'copy_saldos';

    protected $fillable = [
        'from_periode_id',
        'to_periode_id',
        'divisi_id',
        'status_saldo',
        'id'
    ];

    public function divisi()
    {
        return $this->belongsTo('App\Divisi');
    }

    public function from_periode()
    {
        return $this->belongsTo('App\Periode', 'from_periode_id');
    }

    public function to_periode()
    {
        return $this->belongsTo('App\Periode', 'to_periode_id');
    }
}
