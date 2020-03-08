<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PembukuanServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        require_once app_path() . '/Helpers/Pembukuan.php';
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
