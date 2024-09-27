<?php

namespace App\Facades;

use App\Services\CMSAuthors;
use App\Services\CMSThemes;
use App\Services\CMSTypes;
use Illuminate\Support\Facades\Facade;

/**
 * @method CMSAuthors authors()
 * @method CMSTypes types()
 * @method CMSThemes themes()
 */
class CMS extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return 'cms';
    }
}
