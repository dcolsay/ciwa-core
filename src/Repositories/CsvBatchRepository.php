<?php

namespace Dcolsay\Ciwa\Repositories;

use Dcolsay\Ciwa\ContractFactory;
use Spatie\SimpleExcel\SimpleExcelReader;
use Dcolsay\Ciwa\Headings\HeadingFormatter;
use Dcolsay\Ciwa\Objects\Contract;

class CsvBatchRepository
{
    protected $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function rows()
    {
        return SimpleExcelReader::create($this->path)
            ->trimHeaderRow()
            ->formatHeadersUsing(fn($header) => HeadingFormatter::format($header))
            ->getRows();
    }

    public function consentContracts()
    {
        return $this->rows()
            ->filter(function($properties) {
                return $properties['Consented'] == 'Yes';
            })
            ->map(function($properties){
                $contract = Contract::fromArray($properties);
                dd($contract);
            })->count();
    }

    public function contracts()
    {
        return $this->rows()->map(fn($line) => dd(ContractFactory::makeFromArray($line)))
            ->count();
    }
}
