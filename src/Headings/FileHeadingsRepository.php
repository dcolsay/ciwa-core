<?php

namespace  Dcolsay\Ciwa\Headings;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Spatie\SimpleExcel\SimpleExcelReader;
use Dcolsay\Ciwa\Headings\HeadingsRepository;
use Illuminate\Support\LazyCollection;

class FileHeadingsRepository
{
    protected $items;

    protected $format;

    protected $rows;

    protected $key = '';

    protected $value = '';

    public function __construct($path)
    {
        $this->loadFile($path);
    }

    protected function loadFile($path)
    {
        $this->rows = SimpleExcelReader::create($path)
            ->trimHeaderRow()
            ->getRows();
    }

    protected function headers()
    {
        return $this->rows->pluck('output', 'input');
        // return $this->rows->pluck('field', 'key');
    }

    public function values()
    {
        return $this->headers()->toArray();
    }

    public function toArray()
    {
        return $this->values();
    }

    public function search(string $localKey)
    {
        if(blank($localKey))
            dd($localKey);

            $rows = $this->headers();

        if(!$rows->has($localKey))
            return $localKey;

        return $rows->get($localKey);
    }
}

// Ouvrir le fichier et mettre le contenu dans un tableau
