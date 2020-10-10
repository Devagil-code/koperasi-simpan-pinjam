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

    public function transaksi_harian()
    {
        return $this->belongsTo('App\TransaksiHarian', 'transaksi_harian_id');
    }

    public function transaksi_pinjaman()
    {
        return $this->hasOne('App\TransaksiPinjaman', 'transaksi_harian_biaya_id');
    }
}
