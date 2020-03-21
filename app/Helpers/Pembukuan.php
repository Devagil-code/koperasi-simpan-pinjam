<?php

namespace App\Helpers;
use App\Periode;
use App\TransaksiHarian;
use Illuminate\Support\Facades\DB;

class Pembukuan {

    public static function closeBook($divisi_id = null, $jenis_transaksi = null, $biaya_id = null)
    {
        $want_close = Periode::select()->where('status', 2)->first();
        $periode_aktif = Periode::select()->where('status', 1)->first();
        if(!empty($want_close) && !empty($periode_aktif))
        {
            $transaksi_harian = DB::table('transaksi_harians')
                    ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                    ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                    ->where('transaksi_harians.divisi_id', $divisi_id)
                    ->whereIn('transaksi_harian_biayas.biaya_id', $biaya_id)
                    ->where('transaksi_harians.jenis_transaksi', $jenis_transaksi)
                    ->where('transaksi_harians.is_close', '0')
                    ->where('transaksi_harians.periode_id', $want_close->id)
                    ->select('transaksi_harians.id as id')
                    ->orderBy('transaksi_harians.id', 'DESC')
                    ->get();
            if(!empty($transaksi_harian))
            {
                return '1';
            }
        }
    }

    public static function closeBookDivisi($jenis_transaksi = null)
    {

        $want_close = Periode::select()->where('status', 2)->first();
        $periode_aktif = Periode::select()->where('status', 1)->first();
        if(!empty($want_close) && !empty($periode_aktif))
        {
            $transaksi_harian = DB::table('transaksi_harians')
                    ->select('transaksi_harians.id as id', 'transaksi_harians.divisi_id')
                    ->where('transaksi_harians.jenis_transaksi', $jenis_transaksi)
                    ->where('transaksi_harians.is_close', '0')
                    ->where('transaksi_harians.periode_id', $want_close->id)
                    ->whereNotIn('divisi_id', ['1', '2'])
                    ->orderBy('transaksi_harians.id', 'DESC')
                    ->first();
            if(!empty($transaksi_harian))
            {
                return '1';
            }
        }
    }
}