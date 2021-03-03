<?php

namespace Dcolsay\Ciwa;

class ContractFactory
{
    public static function makeFromArray($value)
    {
        return [
            'ContractCode' => $value['ContractCode'],
        ];
        // dd($value);
    }
}
