<?php

namespace Dymantic\LaravelStatic\Tests;

use Dymantic\LaravelStatic\LaravelStaticServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp()
    {
        parent::setUp();

        config()->set('laravel-static.root', __DIR__ . '/fixtures/data');
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelStaticServiceProvider::class
        ];
    }
}