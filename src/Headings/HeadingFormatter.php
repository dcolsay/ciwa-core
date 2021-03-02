<?php

namespace Dcolsay\Ciwa\Headings;

use Illuminate\Support\Facades\Storage;

class HeadingFormatter
{
    public function __invoke(string $key)
    {
        dd($key);
    }

    public static function format(string $key)
    {
        // dd($key);
        $path = Storage::path('settings\header-cceibank.csv');
        if(blank($key))
            dd($key);

        $ciwaHeader = new FileHeadingsRepository($path);
        // dd($ciwaHeader->search($key));
        return $ciwaHeader->search($key);
    }
}
