<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;

enum OrderStatus: int implements \Filament\Support\Contracts\HasLabel, HasColor
{
    use RandomCase;
    use HasLabel;

    case PENDING = 1;
    case PROCESSING = 2;
    case COMPLETED = 3;
    case CANCELLED = 4;

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PENDING => 'gray',
            self::PROCESSING => 'warning',
            self::COMPLETED => 'success',
            self::CANCELLED => 'danger',
        };
    }
}
