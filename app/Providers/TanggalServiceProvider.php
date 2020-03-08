<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class TanggalServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        require_once app_path() . '/Helpers/Tanggal.php';
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
