<?php

namespace App\Filament\Resources\AccountResource\Actions;

use App\Export\ExportAccounts;
use Filament\Forms;
use Filament\Tables\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;

class ExportAccountsAction
{
    public static function make(): Action
    {
        return Action::make('export')
            ->label(trans('account.accounts.export.title'))
            ->requiresConfirmation()
            ->color('info')
            ->icon('heroicon-o-arrow-down-on-square')
            ->fillForm([
                'columns' => [
                    'id' => trans('account.accounts.coulmns.id'),
                    'name' => trans('account.accounts.coulmns.name'),
                    'email' => trans('account.accounts.coulmns.email'),
                    'phone' => trans('account.accounts.coulmns.phone'),
                    'address' => trans('account.accounts.coulmns.address'),
                    'type' => trans('account.accounts.coulmns.type'),
                    'is_login' => trans('account.accounts.coulmns.is_login'),
                    'is_active' => trans('account.accounts.coulmns.is_active'),
                    'created_at' => trans('account.accounts.coulmns.created_at'),
                    'updated_at' => trans('account.accounts.coulmns.updated_at'),
                ],
            ])
            ->form([
                Forms\Components\KeyValue::make('columns')
                    ->label(trans('account.accounts.export.columns'))
                    ->required()
                    ->editableKeys(false)
                    ->addable(false),
            ])
            ->action(function (array $data) {
                return Excel::download(new ExportAccounts($data), 'accounts.csv');
            });
    }
}
