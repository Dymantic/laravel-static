<?php

namespace Dymantic\LaravelStatic;

use Illuminate\Support\ServiceProvider;

class LaravelStaticServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('static-data', function() {
            return new DataRepository(config('laravel-static.root'));
        });
    }
}