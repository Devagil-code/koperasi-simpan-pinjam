<?php

use Illuminate\Database\Seeder;
use App\Anggota;
use App\User;
use App\UserAnggota;
use Laratrust\Models\LaratrustRole as Role;

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
        $anggota->tgl_daftar = '2020-10-05';
        $anggota->status = '1';
        $anggota->save();

        $user = User::create([
            'name' => $anggota->nama,
            'email' => $anggota->nik,
            'password' => bcrypt('Kopkar2019')
        ]);

        $user_anggota = new UserAnggota();
        $user_anggota->anggota_id = $anggota->id;
        $user_anggota->user_id = $user->id;
        $user_anggota->save();
        $roleUser = Role::where('name', 'member')->first();
        $user->attachRole($roleUser);

        $anggota = new Anggota();
        $anggota->nik = '320209050501002';
        $anggota->nama = 'Ahmad Jaelani';
        $anggota->inisial = 'AJ';
        $anggota->homebase = 'Jakarta';
        $anggota->tgl_daftar = '2020-10-05';
        $anggota->status = '1';
        $anggota->save();

        $user = User::create([
            'name' => $anggota->nama,
            'email' => $anggota->nik,
            'password' => bcrypt('Kopkar2019')
        ]);

        $user_anggota = new UserAnggota();
        $user_anggota->anggota_id = $anggota->id;
        $user_anggota->user_id = $user->id;
        $user_anggota->save();

        $user->attachRole($roleUser);

        $anggota = new Anggota();
        $anggota->nik = '320209060601003';
        $anggota->nama = 'Miranda';
        $anggota->inisial = 'M';
        $anggota->homebase = 'Tangerang';
        $anggota->tgl_daftar = '2020-10-05';
        $anggota->status = '1';
        $anggota->save();

        $user = User::create([
            'name' => $anggota->nama,
            'email' => $anggota->nik,
            'password' => bcrypt('Kopkar2019')
        ]);

        $user_anggota = new UserAnggota();
        $user_anggota->anggota_id = $anggota->id;
        $user_anggota->user_id = $user->id;
        $user_anggota->save();

        $user->attachRole($roleUser);

        $anggota = new Anggota();
        $anggota->nik = '320209070701004';
        $anggota->nama = 'Raka Hadi';
        $anggota->inisial = 'RH';
        $anggota->homebase = 'Garut';
        $anggota->tgl_daftar = '2020-10-05';
        $anggota->status = '1';
        $anggota->save();

        $user = User::create([
            'name' => $anggota->nama,
            'email' => $anggota->nik,
            'password' => bcrypt('Kopkar2019')
        ]);

        $user_anggota = new UserAnggota();
        $user_anggota->anggota_id = $anggota->id;
        $user_anggota->user_id = $user->id;
        $user_anggota->save();

        $user->attachRole($roleUser);

        $anggota = new Anggota();
        $anggota->nik = '320209080801005';
        $anggota->nama = 'Hermansyah';
        $anggota->inisial = 'H';
        $anggota->homebase = 'Bekasi';
        $anggota->tgl_daftar = '2020-10-05';
        $anggota->status = '1';
        $anggota->save();

        $user = User::create([
            'name' => $anggota->nama,
            'email' => $anggota->nik,
            'password' => bcrypt('Kopkar2019')
        ]);

        $user_anggota = new UserAnggota();
        $user_anggota->anggota_id = $anggota->id;
        $user_anggota->user_id = $user->id;
        $user_anggota->save();

        $user->attachRole($roleUser);

        $anggota = new Anggota();
        $anggota->nik = '320209080801006';
        $anggota->nama = 'Angga Rojak';
        $anggota->inisial = 'H';
        $anggota->homebase = 'Bekasi';
        $anggota->tgl_daftar = '2020-10-05';
        $anggota->status = '1';
        $anggota->save();

        $user = User::create([
            'name' => $anggota->nama,
            'email' => $anggota->nik,
            'password' => bcrypt('Kopkar2019')
        ]);

        $user_anggota = new UserAnggota();
        $user_anggota->anggota_id = $anggota->id;
        $user_anggota->user_id = $user->id;
        $user_anggota->save();

        $user->attachRole($roleUser);

        $anggota = new Anggota();
        $anggota->nik = '320209080801007';
        $anggota->nama = 'Kardun';
        $anggota->inisial = 'H';
        $anggota->homebase = 'Bekasi';
        $anggota->tgl_daftar = '2020-10-05';
        $anggota->status = '1';
        $anggota->save();

        $user = User::create([
            'name' => $anggota->nama,
            'email' => $anggota->nik,
            'password' => bcrypt('Kopkar2019')
        ]);

        $user_anggota = new UserAnggota();
        $user_anggota->anggota_id = $anggota->id;
        $user_anggota->user_id = $user->id;
        $user_anggota->save();

        $user->attachRole($roleUser);

        $anggota = new Anggota();
        $anggota->nik = '320209080801008';
        $anggota->nama = 'Jaja Miharja';
        $anggota->inisial = 'H';
        $anggota->homebase = 'Bekasi';
        $anggota->tgl_daftar = '2020-10-05';
        $anggota->status = '1';
        $anggota->save();

        $user = User::create([
            'name' => $anggota->nama,
            'email' => $anggota->nik,
            'password' => bcrypt('Kopkar2019')
        ]);

        $user_anggota = new UserAnggota();
        $user_anggota->anggota_id = $anggota->id;
        $user_anggota->user_id = $user->id;
        $user_anggota->save();

        $user->attachRole($roleUser);

        $anggota = new Anggota();
        $anggota->nik = '320209080801009';
        $anggota->nama = 'Miharja';
        $anggota->inisial = 'H';
        $anggota->homebase = 'Bekasi';
        $anggota->tgl_daftar = '2020-10-05';
        $anggota->status = '1';
        $anggota->save();

        $user = User::create([
            'name' => $anggota->nama,
            'email' => $anggota->nik,
            'password' => bcrypt('Kopkar2019')
        ]);

        $user->attachRole($roleUser);

        $user_anggota = new UserAnggota();
        $user_anggota->anggota_id = $anggota->id;
        $user_anggota->user_id = $user->id;
        $user_anggota->save();

        $anggota = new Anggota();
        $anggota->nik = '320209080801010';
        $anggota->nama = 'Santika';
        $anggota->inisial = 'H';
        $anggota->homebase = 'Bekasi';
        $anggota->tgl_daftar = '2020-10-05';
        $anggota->status = '1';
        $anggota->save();

        $user = User::create([
            'name' => $anggota->nama,
            'email' => $anggota->nik,
            'password' => bcrypt('Kopkar2019')
        ]);

        $user->attachRole($roleUser);

        $user_anggota = new UserAnggota();
        $user_anggota->anggota_id = $anggota->id;
        $user_anggota->user_id = $user->id;
        $user_anggota->save();
    }
}
