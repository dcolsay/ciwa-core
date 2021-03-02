<?php

namespace Dcolsay\Ciwa;

class ContractFactory
{
    public static function makeFromArray($value)
    {
        dd($value);
        return [
            'ContractCode' => $value['ContractCode'],
        ];
        // dd($value);
    }
}
