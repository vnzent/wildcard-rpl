<?php

namespace App\Enums;

enum Role: int implements \Filament\Support\Contracts\HasLabel
{
    use HasLabel;
    use RandomCase;

    case ADMINISTRATOR = 1;
    case INVENTORY_MANAGER = 2;
    case CASHIER = 3;
}
