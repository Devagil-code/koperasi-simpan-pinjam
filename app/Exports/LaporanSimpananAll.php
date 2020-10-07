<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\{FromView};
use Illuminate\Contracts\View\View;

class LaporanSimpananAll implements WithTitle, FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $shet_name;
    protected $sum_pokok;
    protected $transaksi_harian;
    protected $sum_wajib;
    protected $sum_sukarela;
    protected $sum_kredit_simpanan;

    public function __construct($shet_name, $sum_pokok, $transaksi_harian, $sum_wajib, $sum_sukarela, $sum_kredit_simpanan)
    {
        $this->shet_name = $shet_name;
        $this->sum_pokok = $sum_pokok;
        $this->transaksi_harian = $transaksi_harian;
        $this->sum_wajib = $sum_wajib;
        $this->sum_sukarela = $sum_sukarela;
        $this->sum_kredit_simpanan = $sum_kredit_simpanan;
    }

    public function title(): string
    {
        return $this->shet_name;
    }

    public function view(): View
    {
        return view('excell.simpanan-all', [
            'transaksi_harian' => $this->transaksi_harian,
            'sum_pokok' => $this->sum_pokok,
            'sum_wajib' => $this->sum_wajib,
            'sum_sukarela' => $this->sum_sukarela,
            'sum_kredit_simpanan' => $this->sum_kredit_simpanan
        ]);
    }
}
