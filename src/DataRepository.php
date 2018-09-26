<?php


namespace Dymantic\LaravelStatic;


use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class DataRepository
{

    private $items;

    public function __construct($root)
    {
        if (!is_dir($root)) {
            $this->items = [];

            return;
        }

        config()->set('filesystems.disks.laravel-static.driver', 'local');
        config()->set('filesystems.disks.laravel-static.root', $root);

        $base = [];

        collect(Storage::disk('laravel-static')->allFiles())
            ->flatMap(function ($path) use ($root) {
                return [str_replace('.php', '', $path) => realpath($root . DIRECTORY_SEPARATOR . $path)];
            })->each(function ($path, $key) use (&$base) {
                $dots = str_replace('/', '.', $key);
                Arr::set($base, $dots, require $path);
            });

        $this->items = $base;
    }

    public function all()
    {
        return $this->items;
    }

    public function get($item_key, $default = null)
    {
        return Arr::get($this->items, $item_key, $default);
    }
}