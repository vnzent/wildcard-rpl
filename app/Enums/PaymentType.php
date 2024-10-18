<?php

namespace App\Enums;

enum PaymentType: int
{
    use RandomCase;

    case CASH = 1;
    case TRANSFER = 2;
    case CALL_OF_DUTY_MOBILE = 3;
}
