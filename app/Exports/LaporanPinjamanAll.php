<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\{FromView};
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;

class LaporanPinjamanAll implements WithTitle, FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $shet_name;
    protected $transaksi_harian;
    protected $sum_cicilan;
    protected $sum_bunga;
    protected $sum_kredit_pinjaman;

    public function __construct($shet_name, $transaksi_harian, $sum_cicilan, $sum_bunga, $sum_kredit_pinjaman)
    {
        $this->shet_name = $shet_name;
        $this->transaksi_harian = $transaksi_harian;
        $this->sum_bunga = $sum_bunga;
        $this->sum_cicilan = $sum_cicilan;
        $this->sum_kredit_pinjaman = $sum_kredit_pinjaman;
    }

    public function title(): string
    {
        return $this->shet_name;
    }

    public function view(): View
    {
        return view('excell.pinjaman-all', [
            'transaksi_harian' => $this->transaksi_harian,
            'sum_bunga' => $this->sum_bunga,
            'sum_cicilan' => $this->sum_cicilan,
            'sum_kredit_pinjaman' => $this->sum_kredit_pinjaman
        ]);
    }
}
