<?php

namespace App\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;


/**
 * @method static void register(array|string $type, string $for)
 * @method static Collection getFor()
 * @method static Collection getTypes(string $for)
 */
class Types extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'types';
    }
}
