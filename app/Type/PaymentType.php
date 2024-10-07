<?php

namespace App\Type;

enum PaymentType: int
{
    case CASH = 1;
    case TRANSFER = 2;
}
