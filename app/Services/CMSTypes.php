<?php

namespace App\Services;

use App\Services\Contracts\CmsType;
use Illuminate\Support\Collection;

class CMSTypes
{
    public static array $cmsTypes = [];

    public static function register(CmsType|array $cmsType): void
    {
        if (is_array($cmsType)) {
            foreach ($cmsType as $type) {
                self::register($type);
            }

            return;
        }

        self::$cmsTypes[] = $cmsType;
    }

    public static function getOptions(): Collection
    {
        return collect(self::$cmsTypes);
    }
}
