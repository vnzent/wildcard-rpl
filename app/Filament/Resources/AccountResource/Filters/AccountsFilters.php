<?php

namespace App\Filament\Resources\AccountResource\Filters;

use App\Models\Type;
use Filament\Tables;
use TomatoPHP\FilamentHelpers\Contracts\FiltersBuilder;

class AccountsFilters extends FiltersBuilder
{
    public function filters(): array
    {
        $filters = [
            Tables\Filters\TrashedFilter::make(),
            Tables\Filters\SelectFilter::make('type')
                ->label(trans('account.accounts.filters.type'))
                ->searchable()
                ->preload()
                ->options(Type::query()->where('for', 'accounts')->where('type', 'type')->pluck('name', 'key')->toArray()),
            Tables\Filters\TernaryFilter::make('is_login')
                ->label(trans('account.accounts.filters.is_login')),
            Tables\Filters\TernaryFilter::make('is_active')
                ->label(trans('account.accounts.filters.is_active')),
        ];

        return $filters;
    }
}
