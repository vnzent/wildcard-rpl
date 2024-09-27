<?php

namespace App\Filament\Resources\AccountResource\Pages;

class AccountPagesList
{
    public static function routes(): array
    {
        return [
            'index' => ListAccounts::route('/'),
            'edit' => EditAccount::route('/{record}/edit'),
        ];
    }
}
