<?php

namespace Dcolsay\Ciwa\Headings;

use Exception;
use Illuminate\Support\Facades\Storage;

class HeadingFormatter
{
    public function __invoke(string $key)
    {
        dd($key);
    }

    public static function format(string $key)
    {
        // $path = Storage::path('settings\header-ebj.csv');
        $path = Storage::path('settings\header-uba.csv');
        
        if(blank($key))
            throw new Exception('Key can not null');

        $ciwaHeader = new FileHeadingsRepository($path);
        return $ciwaHeader->search($key);
    }
}
