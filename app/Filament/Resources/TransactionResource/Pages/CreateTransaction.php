<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Check if 'order_id' is passed in the query string and set it
        if (request()->has('order_id')) {
            $data['order_id'] = request()->get('order_id');
        }

        return $data;
    }
}
