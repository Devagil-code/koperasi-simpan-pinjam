<?php

use Illuminate\Database\Seeder;
use App\Anggota;

class AnggotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $anggota = new Anggota();
        $anggota->nik = '320209040401001';
        $anggota->nama = 'Agus Permana';
        $anggota->inisial = 'AP';
        $anggota->homebase = 'Bogor';
        $anggota->status = '1';
        $anggota->save();

        $anggota = new Anggota();
        $anggota->nik = '320209050501002';
        $anggota->nama = 'Ahmad Jaelani';
        $anggota->inisial = 'AJ';
        $anggota->homebase = 'Jakarta';
        $anggota->status = '1';
        $anggota->save();

        $anggota = new Anggota();
        $anggota->nik = '320209060601003';
        $anggota->nama = 'Miranda';
        $anggota->inisial = 'M';
        $anggota->homebase = 'Tangerang';
        $anggota->status = '1';
        $anggota->save();

        $anggota = new Anggota();
        $anggota->nik = '320209070701004';
        $anggota->nama = 'Raka Hadi';
        $anggota->inisial = 'RH';
        $anggota->homebase = 'Garut';
        $anggota->status = '1';
        $anggota->save();

        $anggota = new Anggota();
        $anggota->nik = '320209080801005';
        $anggota->nama = 'Hermansyah';
        $anggota->inisial = 'H';
        $anggota->homebase = 'Bekasi';
        $anggota->status = '1';
        $anggota->save();

    }
}
