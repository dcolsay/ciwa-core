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
        if(blank($key))
            return; 
        
        $path = Storage::path('settings\header-ebj.csv');
        // $path = Storage::path('settings\header-uba.csv');

        $ciwaHeader = new FileHeadingsRepository($path);
        return $ciwaHeader->search($key);
    }
}
