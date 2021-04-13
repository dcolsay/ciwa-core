<?php

namespace Dcolsay\Ciwa\Sorters;

use Illuminate\Support\Facades\Storage;
use Stringable;

class SorterFactory
{

    public static function makeFromPath(Stringable $key, $format)
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
    }
}
