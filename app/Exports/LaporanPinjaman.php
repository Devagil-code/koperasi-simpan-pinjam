<?php

namespace App\Exports;

use App\TransaksiHarian;
use Maatwebsite\Excel\Concerns\{FromView};
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\View\View;

class LaporanPinjaman implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $transaksi_harian;
    protected $sum_cicilan;
    protected $sum_bunga;
    protected $sum_kredit_pinjaman;
    protected $nik;

    public function __construct($transaksi_harian, $sum_cicilan, $sum_bunga, $sum_kredit_pinjaman, $nik)
    {
        $this->transaksi_harian = $transaksi_harian;
        $this->sum_bunga = $sum_bunga;
        $this->sum_cicilan = $sum_cicilan;
        $this->sum_kredit_pinjaman = $sum_kredit_pinjaman;
        $this->nik = $nik;
    }

    public function collection()
    {
        return $this->transaksi_harian;
    }

    public function view(): View
    {
        return view('excell.pinjaman', [
            'transaksi_harian' => $this->transaksi_harian,
            'sum_bunga' => $this->sum_bunga,
            'sum_cicilan' => $this->sum_cicilan,
            'sum_kredit_pinjaman' => $this->sum_kredit_pinjaman,
            'nik' => $this->nik
        ]);
    }
}
