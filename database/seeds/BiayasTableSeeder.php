<?php

use Illuminate\Database\Seeder;
use App\Divisi;
use App\Biaya;

class BiayasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //Divisi Simpan
        $divisi = new Divisi();
        $divisi->name = 'SIMPAN';
        $divisi->save();

        //Debet Simpanan Pokok
        $biaya = new Biaya();
        $biaya->name = 'SIMPANAN POKOK';
        $biaya->divisi_id = $divisi->id;
        $biaya->jenis_biaya = '1';
        $biaya->id = '1';
        $biaya->save();

        //Debet Simpanan Wajib
        $biaya = new Biaya();
        $biaya->name = 'SIMPANAN WAJIB';
        $biaya->divisi_id = $divisi->id;
        $biaya->jenis_biaya = '1';
        $biaya->id = '2';
        $biaya->save();

        //Debet Simpanan Sukarela
        $biaya = new Biaya();
        $biaya->name = 'SIMPANAN Sukarela';
        $biaya->divisi_id = $divisi->id;
        $biaya->jenis_biaya = '1';
        $biaya->id = '3';
        $biaya->save();

        //Kredit Simpanan Seluruh
        $biaya = new Biaya();
        $biaya->name = 'Ambil Simpanan';
        $biaya->divisi_id = $divisi->id;
        $biaya->jenis_biaya = '2';
        $biaya->id = '4';
        $biaya->save();

        //Divisi Pinjam
        $divisi = new Divisi();
        $divisi->name = 'PINJAM';
        $divisi->save();

        //Debet Nominal Angsuran
        $biaya = new Biaya();
        $biaya->name = 'Angsuran Pinjaman';
        $biaya->divisi_id = $divisi->id;
        $biaya->jenis_biaya = '1';
        $biaya->id = '6';
        $biaya->save();

        //Debet Bunga Pinjaman
        $biaya = new Biaya();
        $biaya->name = 'Bunga Pinjaman';
        $biaya->divisi_id = $divisi->id;
        $biaya->id = '7';
        $biaya->jenis_biaya = '1';
        $biaya->save();

        //Pinjaman Uang Ke Koperasi
        $biaya = new Biaya();
        $biaya->name = 'Nominal Pinjaman';
        $biaya->divisi_id = $divisi->id;
        $biaya->jenis_biaya = '2';
        $biaya->id = '8';
        $biaya->save();

        $divisi = new Divisi();
        $divisi->name = 'Kopi';
        $divisi->save();

        $biaya = new Biaya();
        $biaya->name = 'Debet Kopi';
        $biaya->divisi_id = $divisi->id;
        $biaya->id = '9';
        $biaya->jenis_biaya = '1';
        $biaya->save();

        //Pinjaman Uang Ke Koperasi
        $biaya = new Biaya();
        $biaya->name = 'Kredit Kopi';
        $biaya->divisi_id = $divisi->id;
        $biaya->jenis_biaya = '2';
        $biaya->id = '10';
        $biaya->save();
    }
}
