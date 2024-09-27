<?php

namespace App\Services;

use App\Services\Contracts\CmsAuthor;
use Illuminate\Support\Collection;

class CMSAuthors
{
    public static array $authorTypes = [];

    public static function register(CmsAuthor|array $author): void
    {
        if (is_array($author)) {
            foreach ($author as $type) {
                self::register($type);
            }

            return;
        }
        self::$authorTypes[] = $author;
    }

    public static function getOptions(): Collection
    {
        return collect(self::$authorTypes);
    }
}
