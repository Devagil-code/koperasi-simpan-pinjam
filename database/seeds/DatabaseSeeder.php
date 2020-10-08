<?php

use App\Anggota;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ModuleSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(PeriodesTableSeeder::class);
        $this->call(OptionsTableSeeder::class);
        $this->call(BiayasTableSeeder::class);
        $this->call(AnggotaSeeder::class);
        $this->call(CopySaldoSeeder::class);
    }
}
