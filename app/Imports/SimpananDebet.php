<?php

namespace App\Imports;

use App\TransaksiHarian;
use Maatwebsite\Excel\Concerns\ToModel;
use Tanggal;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\TransaksiHarianAnggota;
use App\Anggota;
use App\TransaksiHarianBiaya;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithValidation;

class SimpananDebet implements ToCollection, WithStartRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    protected $periode;
	protected $anggota;

    public function __construct($periode)
    {
        $this->periode = $periode;
    }

    public function startRow(): int
    {
        return 2;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {

            $transaksiHarian = TransaksiHarian::create([
                'divisi_id' => '1',
                'tgl' => Tanggal::transformDate($row[1]),
                'jenis_pembayaran' => $row[2],
                'keterangan' => $row[3],
                'jenis_transaksi' => '1',
                'periode_id' => $this->periode->id,
            ]);
            //$anggota = DB::table('anggotas')->select('id')->where('nik', '=', $row[4])->first();
			$this->anggota = Anggota::select()->where('nik', '=', $row[4])->value('id');
			//$anggota =  collect(\DB::select("SELECT id FROM anggotas WHERE nik=$row[4]"))->value('id'); ;
			//dd($this->anggota);
		    //dd($anggota);
            TransaksiHarianAnggota::create([
                'transaksi_harian_id' => $transaksiHarian->id,
                'anggota_id' => $this->anggota
            ]);
			//dd($row[7]);
            for ($i=0; $i <= 3 ; $i++) {
                if($i === 1)
                {
                    TransaksiHarianBiaya::create([
                        'transaksi_harian_id' => $transaksiHarian->id,
                        'biaya_id' => '1',
                        'nominal' => $row[5]
                    ]);
                }
                if($i ===  2)
                {
                    TransaksiHarianBiaya::create([
                        'transaksi_harian_id' => $transaksiHarian->id,
                        'biaya_id' => '2',
                        'nominal' => $row[6]
                    ]);
                }

                if($i === 3)
                {
                    TransaksiHarianBiaya::create([
                        'transaksi_harian_id' => $transaksiHarian->id,
                        'biaya_id' => '3',
                        'nominal' => $row[7]
                    ]);
                }
            }
        }
    }

    public function rules(): array
    {
        return [
            '0' => 'required',

            // Above is alias for as it always validates in batches
            '*.0' => 'required',

            '1' => 'required',

            // Above is alias for as it always validates in batches
            '*.1' => 'required',

            '2' => 'required',

            // Above is alias for as it always validates in batches
            '*.2' => 'required',
            '3' => 'required',

            // Above is alias for as it always validates in batches
            '*.3' => 'required',

            '4' => 'required',

            // Above is alias for as it always validates in batches
            '*.4' => 'required',
        ];
    }
}
