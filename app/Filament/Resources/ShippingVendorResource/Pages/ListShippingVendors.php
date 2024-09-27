<?php

namespace App\Filament\Resources\ShippingVendorResource\Pages;

use App\Filament\Resources\ShippingVendorResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ListShippingVendors extends ManageRecords
{
    protected static string $resource = ShippingVendorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
