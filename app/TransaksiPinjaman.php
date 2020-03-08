<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiPinjaman extends Model
{
    //

    protected $fillable = [
        'transaksi_harian_biaya_id',
        'lama_cicilan'
    ];
    
    public function transaksi_harian_biaya()
    {
        return $this->hasOne('App\TransaksiHarianBiaya');
    }
}
