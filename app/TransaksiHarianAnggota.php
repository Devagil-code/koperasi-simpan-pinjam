<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiHarianAnggota extends Model
{
    //

    protected $fillable = [
        'transaksi_harian_id',
        'anggota_id'
    ];

	public function anggota()
	{
		return $this->belongsTo('App\Anggota', 'anggota_id');
	}


	/*public function transaksi_harian()
	{
		return $this->hasOne('App\TransaksiHarian');
	}
	*/
}
