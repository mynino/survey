<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DataProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton("nino\Facades\Data",function(){
            return new nino\Services\DataService();
        });
    }
}
