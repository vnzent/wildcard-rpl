<?php

namespace App\Enums;

enum OrderStatus: int
{
    case PENDING = 1;
    case PROCESSING = 2;
    case COMPLETED = 3;
    case CANCELLED = 4;

    public static function random(): OrderStatus
    {
        return self::cases()[array_rand(self::cases())];
    }
}
