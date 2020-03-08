<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MoneyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        require_once app_path() . '/Helpers/Money.php';
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
