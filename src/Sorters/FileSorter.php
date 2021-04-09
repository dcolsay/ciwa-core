<?php

namespace Dcolsay\Ciwa\Sorters;

use Dcolsay\Ciwa\Concerns\HandleFile;
use Illuminate\Support\LazyCollection;

class FileSorter
{
    use HandleFile;

    protected LazyCollection $rows;

    protected $field = 'field';

    protected $position = 'position';

    public function __construct($path)
    {
        $this->loadFile($path);
    }

    public static function makeWithHeader($path, $field, $position)
    {
        return (new static($path));
    }

    public function values()
    {
        return $this->rows->pluck($this->position, $this->field);

    }

    public function order($data)
    {
        $keys = array_keys($data);

        $sorter = $this->rows
            ->pluck($this->field, $this->position)
            // ->mapWithKeys(fn($value, $key) => [intval($key) => $value])
            ->sortKeys()
            ->toArray();

        $order = array_intersect($sorter, $keys);

        //  @see https://www.designcise.com/web/tutorial/how-to-sort-an-array-by-keys-based-on-order-in-a-secondary-array-in-php
        return array_merge(array_flip($order), $data);
    }

    public function position($field)
    {
        if(!($field == "TypeOfContract"))
            return ;

        if(!$this->rows->contains($this->field, $field))
            return $this->rows->count() + 1;

            // dd($this->rows->firstWhere($this->field, $field));
        // dd(intval($this->rows->firstWhere($this->field, $field)[$this->position]));

        return intval($this->rows->firstWhere($this->field, $field)[$this->position]);
    }
    public function toArray()
    {
        return $this->values()->toArray();
    }
}
