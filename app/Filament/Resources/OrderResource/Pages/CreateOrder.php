<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Enums\OrderStatus;
use App\Filament\Resources\OrderResource;
use App\Filament\Traits\RedirectToIndexAfterCreate;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    use RedirectToIndexAfterCreate;

    protected static string $resource = OrderResource::class;
}
