<?php

namespace RomaMb\Press\Facades;

use Illuminate\Support\Facades\Facade;

class Press extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'Press';
    }
}
