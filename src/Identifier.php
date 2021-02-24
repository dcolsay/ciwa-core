<?php

namespace Dcolsay\Ciwa\Identifier;

class Identifier
{
    public $number;

    public $year;

    public $month;

    public $version;

    public $format = 'XML';

    public $periodicity = 'M';

    public function toArray()
    {
        return [
            $this->number,
            "{$this->year}{$this->month}",
            $this->periodicity,
            $this->version,
            $this->format
        ];
    }

    public function toString()
    {
        return sprintf('%s_%s_%s_DEF_%s_%s', $this->toArray());
    }


}
