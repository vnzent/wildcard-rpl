<?php

namespace App\Filament\Resources\AccountResource\Pages;

use App\Filament\Resources\AccountResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ListAccounts extends ManageRecords
{
    protected static string $resource = AccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->using(function (array $data) {
                    if (isset($data['password'])) {
                        $data['password'] = bcrypt($data['password']);
                    }
                    if (isset($data['loginBy']) && $data['loginBy'] === 'email') {
                        $data['username'] = $data['email'];
                    } elseif (isset($data['loginBy']) && $data['loginBy'] === 'phone') {
                        $data['username'] = $data['phone'];
                    } else {
                        $data['username'] = $data['email'];
                    }

                    return config('filament-accounts.model')::query()->create($data);
                }),
            Actions\Action::make('types')
                ->icon('heroicon-s-cog')
                ->tooltip('Accounts Types')
                ->label('Accounts Types')
                ->hiddenLabel()
                ->url(AccountTypes::getUrl()),
        ];
    }
}
