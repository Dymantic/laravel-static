<?php

namespace Dymantic\LaravelStatic;

use Illuminate\Support\ServiceProvider;

class LaravelStaticServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/laravel-static.php' => config_path('laravel-static.php')
        ]);
    }

    public function register()
    {
        $this->app->singleton('static-data', function() {
            return new DataRepository(config('laravel-static.root'));
        });
    }
}