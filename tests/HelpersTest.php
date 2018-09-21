<?php


namespace Dymantic\LaravelStatic\Tests;


use Dymantic\LaravelStatic\DataRepository;

class HelpersTest extends TestCase
{
    /**
     *@test
     */
    public function a_helper_function_is_registered_to_retrieve_repo_from_app()
    {
        $repo = data();

        $this->assertInstanceOf(DataRepository::class, $repo);
    }

    /**
     *@test
     */
    public function if_a_string_value_is_passed_to_the_helper_it_will_return_value_of_get()
    {
        config()->set('laravel-static.root', __DIR__ . '/fixtures/data');

        $this->assertEquals([1,2,3,4,5], data('nums'));
        $this->assertEquals('foo_value_one', data('key_vals.foo_key_one'));
        $this->assertEquals(1, data('nested.level_two.key.inner_key'));
    }

    /**
     *@test
     */
    public function a_default_value_can_also_be_provided_to_the_helper()
    {
        config()->set('laravel-static.root', __DIR__ . '/fixtures/data');

        $this->assertEquals('DEFAULT VALUE', data('does.not.exist', 'DEFAULT VALUE'));
    }
}