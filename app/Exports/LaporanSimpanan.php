<?php

namespace App\Exports;

use App\TransaksiHarian;
use Maatwebsite\Excel\Concerns\{FromView};
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\View\View;

class LaporanSimpanan implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $transaksi_harian;
    protected $sum_pokok;
    protected $sum_wajib;
    protected $sum_sukarela;
    protected $sum_kredit_simpanan;
    protected $nik;

    public function __construct($transaksi_harian, $sum_pokok, $sum_wajib, $sum_sukarela, $sum_kredit_simpanan, $nik)
    {
        $this->transaksi_harian = $transaksi_harian;
        $this->sum_pokok = $sum_pokok;
        $this->sum_wajib = $sum_wajib;
        $this->sum_sukarela = $sum_sukarela;
        $this->sum_kredit_simpanan = $sum_kredit_simpanan;
        $this->nik = $nik;
    }

    public function view(): View
    {
        return view('excell.simpanan', [
            'transaksi_harian' => $this->transaksi_harian,
            'sum_pokok' => $this->sum_pokok,
            'sum_wajib' => $this->sum_wajib,
            'sum_sukarela' => $this->sum_sukarela,
            'sum_kredit_simpanan' => $this->sum_kredit_simpanan,
            'nik' => $this->nik
        ]);
    }
}
