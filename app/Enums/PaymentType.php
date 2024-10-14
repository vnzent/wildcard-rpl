<?php

namespace App\Enums;

enum PaymentType: int
{
    case CASH = 1;
    case TRANSFER = 2;
    case CALL_OF_DUTY_MOBILE = 3;

    public static function random(): PaymentType
    {
        return self::cases()[array_rand(self::cases())];
    }
}
