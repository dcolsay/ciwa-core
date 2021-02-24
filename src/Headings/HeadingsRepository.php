<?php

namespace Dcolsay\Ciwa\Headings;

interface HeadingsRepository
{
    public function get(string $key):string;
}
