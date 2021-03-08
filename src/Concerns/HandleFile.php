<?php

namespace Dcolsay\Ciwa\Concerns;

use Spatie\SimpleExcel\SimpleExcelReader;

trait HandleFile
{
    protected function loadFile($path)
    {
        $this->rows = SimpleExcelReader::create($path)
            ->trimHeaderRow()
            ->getRows();
    }
}
