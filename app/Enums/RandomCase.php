<?php

namespace App\Enums;

use Arr;

trait RandomCase
{
    public static function random(self|array $excepts = []): Role
    {
        $excepts = Arr::wrap($excepts);

        $cases = self::cases();

        $filteredCases = array_filter($cases, function ($case) use ($excepts) {
            return ! in_array($case, $excepts);
        });

        return $filteredCases[array_rand($filteredCases)];
    }
}
