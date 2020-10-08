<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Facades\DB;
use App\TransaksiHarian;

class ExportPinjamanAll implements WithMultipleSheets
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $anggota;

    protected $start_date;
    protected $end_date;
    protected $date_before;
    protected $periode_aktif;

    public function __construct($anggota, $start_date, $end_date, $date_before, $periode_aktif)
    {
        $this->anggota = $anggota;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->date_before = $date_before;
        $this->periode_aktif = $periode_aktif;
    }

    public function sheets(): array
    {
        $sheets = [];

        foreach ($this->anggota as $row) {
            $sum_cicilan = DB::table('transaksi_harians')
                ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                ->whereBetween('transaksi_harians.tgl', [$this->periode_aktif->open_date, $this->date_before])
                ->where('transaksi_harian_anggotas.anggota_id', $row->id)
                ->where('transaksi_harian_biayas.biaya_id', '6')
                ->where('divisi_id', '2')
                ->sum('transaksi_harian_biayas.nominal');
            $transaksi_harian = TransaksiHarian::with('transaksi_harian_biaya', 'transaksi_harian_anggota', 'sumCicilan', 'sumBunga', 'sumKreditPinjaman')
                ->whereHas('transaksi_harian_anggota', function ($q) use ($row) {
                    $q->where('anggota_id', $row->id);
                })
                ->whereBetween('tgl', [$this->start_date, $this->end_date])
                ->where('divisi_id', '2')
                ->orderBy('tgl', 'ASC')
                ->get();
            $sum_kredit_pinjaman = DB::table('transaksi_harians')
                ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                ->whereBetween('transaksi_harians.tgl', [$this->periode_aktif->open_date, $this->date_before])
                ->where('transaksi_harian_anggotas.anggota_id', $row->id)
                ->where('transaksi_harian_biayas.biaya_id', '8')
                ->where('divisi_id', '2')
                ->sum('transaksi_harian_biayas.nominal');
            $sum_bunga = DB::table('transaksi_harians')
                ->join('transaksi_harian_biayas', 'transaksi_harians.id', '=', 'transaksi_harian_biayas.transaksi_harian_id')
                ->join('transaksi_harian_anggotas', 'transaksi_harians.id', '=', 'transaksi_harian_anggotas.transaksi_harian_id')
                ->whereBetween('transaksi_harians.tgl', [$this->periode_aktif->open_date, $this->date_before])
                ->where('transaksi_harian_anggotas.anggota_id', $row->id)
                ->where('transaksi_harian_biayas.biaya_id', '7')
                ->where('divisi_id', '2')
                ->sum('transaksi_harian_biayas.nominal');

            $sheets[] = new LaporanPinjamanAll($row->nama, $transaksi_harian, $sum_cicilan, $sum_bunga, $sum_kredit_pinjaman);
        }

        return $sheets;
    }
}
