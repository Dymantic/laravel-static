<?php


namespace Dymantic\LaravelStatic\Tests;


use Dymantic\LaravelStatic\DataRepository;

class ServiceProviderTest extends TestCase
{
    /**
     *@test
     */
    public function it_binds_the_data_repository_to_app_as_a_singleton()
    {
        $dataRepo = app('static-data');

        $this->assertInstanceOf(DataRepository::class, $dataRepo);

        $this->assertEquals($dataRepo, app('static-data'));
    }
}