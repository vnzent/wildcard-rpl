<?php

namespace App\Enums;

enum PaymentType: int implements \Filament\Support\Contracts\HasLabel
{
    use RandomCase;
    use HasLabel;

    case CASH = 1;
    case TRANSFER = 2;
    case CALL_OF_DUTY_MOBILE = 3;
}
