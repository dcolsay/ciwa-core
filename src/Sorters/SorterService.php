<?php

namespace Dcolsay\Ciwa\Sorters;

use Dcolsay\Ciwa\Sorters\FileSorter;
use Illuminate\Support\Facades\Storage;

class SorterService
{
    public static function makeSort($item, $key, $format)
    {
        // @todo Mettre cette variable dans un variable de configuration
        $basePath = Storage::path('settings\tpl');

        // Récupération des positions
        $path = $key->lower()
            ->prepend(DIRECTORY_SEPARATOR)
            ->prepend($basePath)
            ->append('-')
            ->append(strtolower($format))
            ->append('.csv');

        return (new FileSorter($path))->order($item);
    }
}
