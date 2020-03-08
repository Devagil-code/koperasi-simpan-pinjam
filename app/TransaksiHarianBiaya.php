<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiHarianBiaya extends Model
{
    //
    protected $fillable = [
        'transaksi_harian_id',
        'biaya_id',
        'nominal'
    ];

    public function biaya()
    {
        return $this->belongsTo('App\Biaya', 'biaya_id');
    }
}
