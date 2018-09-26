<?php


namespace Dymantic\LaravelStatic;


use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class DataRepository
{

    private $items;

    public function __construct($root)
    {
        if(!is_dir($root)) {
            $this->items = [];
            return;
        }

        config()->set('filesystems.disks.laravel-static.driver', 'local');
        config()->set('filesystems.disks.laravel-static.root', $root);

        $files = collect(Storage::disk('laravel-static')->allFiles());

        $this->items = $files->flatMap(function($path) use ($root) {
            return [str_replace('.php', '', $path) => realpath($root . DIRECTORY_SEPARATOR . $path)];
        })->flatMap(function($path, $key) {
            if(str_contains($key, '/')) {
                $dots = str_replace('/', '.', $key);
                $base = [];
                Arr::set($base, $dots, require $path);
                return $base;
            }
            return [$key => require $path];
        })->all();
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