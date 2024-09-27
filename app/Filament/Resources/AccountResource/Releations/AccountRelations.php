<?php

namespace App\Filament\Resources\AccountResource\Releations;

use App\Facades\Accounts;
use App\Filament\Resources\AccountResource\RelationManagers\AccountLocationsManager;
use App\Filament\Resources\AccountResource\RelationManagers\AccountMetaManager;
use App\Filament\Resources\AccountResource\RelationManagers\AccountRequestsManager;

class AccountRelations
{
    public static function get(): array
    {
        $loadRelations = Accounts::loadRelations();

        $relations = [
            AccountMetaManager::make(),
            AccountLocationsManager::make(),
            AccountRequestsManager::make(),
        ];

        return array_merge($relations, $loadRelations);
    }
}
