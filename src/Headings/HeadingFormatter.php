<?php

namespace Dcolsay\Ciwa\Headings;

use Exception;
use Illuminate\Support\Facades\Storage;
use Dcolsay\Ciwa\Headings\HeadingsRepository;

class HeadingFormatter
{
    public function __invoke(string $key)
    {
        return app(HeadingsRepository::class)->get($key);
    }

     // HeadingRowFormatter::extend('ciwa', function($value) {
        //     dd($value);
        //     $value = Str::lower($value)

        //     $value = (Arr::exists($headings, $value))
        //          ? $headings[$value]
        //          : $value;

        //     return $value;
        // });
}
