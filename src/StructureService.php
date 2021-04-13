<?php

namespace Dcolsay\Ciwa;

use Illuminate\Support\Str;

class StructureService
{
    public static function get($key, $version=1)
    {
        return collect(config("ciwa.orders.bic.v{$version}.{$key}"));
    }

    public static function studly($key, $version=1)
    {
        return self::get($key, $version)->map(fn($item) => Str::studly($item));
    }

    public static function studlyArray($key, $version=1)
    {
       return self::studly($key, $version)->toArray();
    }
}
