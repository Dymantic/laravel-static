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
        $this->items = collect(scandir($root))->reject(function($path) use ($root) {
            return is_dir($root . DIRECTORY_SEPARATOR . $path);
        })->flatMap(function($path) use ($root) {
            return [str_replace('.php', '', $path) => realpath($root . DIRECTORY_SEPARATOR . $path)];
        })->flatMap(function($path, $key) {
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