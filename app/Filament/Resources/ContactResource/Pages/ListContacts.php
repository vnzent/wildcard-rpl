<?php

namespace App\Filament\Resources\ContactResource\Pages;

use App\Filament\Resources\ContactResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ListContacts extends ManageRecords
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('status')
                ->label('Manage Status')
                ->icon('heroicon-s-tag')
                ->url(ContactStatusTypes::getUrl()),
        ];
    }
}
