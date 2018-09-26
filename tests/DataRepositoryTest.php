<?php


namespace Dymantic\LaravelStatic\Tests;


use Dymantic\LaravelStatic\DataRepository;

class DataRepositoryTest extends TestCase
{
    /**
     * @test
     */
    public function it_loads_the_static_data_correctly_on_construction()
    {
        $root = __DIR__ . '/fixtures/data';
        $repo = new DataRepository($root);

        $expected = [
            'key_vals' => ['foo_key_one' => 'foo_value_one', 'foo_key_two' => 'foo_value_two'],
            'nums'     => [1, 2, 3, 4, 5],
            'nested'   => [
                'level_one' => [
                    'key' => 'value'
                ],
                'level_two' => [
                    'key' => ['inner_key' => 1]
                ]
            ]
        ];

        $this->assertEquals($expected, $repo->all());
    }

    /**
     *@test
     */
    public function it_loads_files_in_nested_directories()
    {
        $root = __DIR__ . '/fixtures/nested_dir_data';
        $repo = new DataRepository($root);

        $expected = [
            'key_vals' => ['foo_key_one' => 'foo_value_one', 'foo_key_two' => 'foo_value_two'],
            'nums'     => [1, 2, 3, 4, 5],
            'nested'   => [
                'level_one' => [
                    'level_two' => ['key' => 'value']
                ]
            ]
        ];

        $this->assertEquals($expected, $repo->all());
    }

    /**
     *@test
     */
    public function the_value_of_a_data_file_can_be_retrieved_from_the_repo_using_dot_notation()
    {
        $root = __DIR__ . '/fixtures/data';
        $repo = new DataRepository($root);

        $this->assertEquals([1,2,3,4,5], $repo->get('nums'));
        $this->assertEquals('foo_value_one', $repo->get('key_vals.foo_key_one'));
        $this->assertEquals(1, $repo->get('nested.level_two.key.inner_key'));
    }

    /**
     *@test
     */
    public function a_default_value_can_be_provided_for_when_a_key_is_not_found()
    {
        $root = __DIR__ . '/fixtures/data';
        $repo = new DataRepository($root);

        $this->assertEquals('USE ME INSTEAD', $repo->get('key.does.not.exist', 'USE ME INSTEAD'));
    }
}