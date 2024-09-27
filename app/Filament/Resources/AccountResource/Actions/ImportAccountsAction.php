<?php

namespace App\Filament\Resources\AccountResource\Actions;

use App\Import\ImportAccounts;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Maatwebsite\Excel\Facades\Excel;

class ImportAccountsAction
{
    public static function make(): Action
    {
        return Action::make('import')
            ->label(trans('account.accounts.import.title'))
            ->form([
                Forms\Components\FileUpload::make('excel')
                    ->hint(trans('account.accounts.import.hint'))
                    ->label(trans('account.accounts.import.excel'))
                    ->acceptedFileTypes(['text/csv', 'application/vnd.ms-excel'])
                    ->required(),
            ])
            ->action(function (array $data) {
                try {
                    Excel::import(new ImportAccounts, storage_path('app/public/'.$data['excel']));

                    Notification::make()
                        ->title(trans('account.accounts.import.success'))
                        ->body(trans('account.accounts.import.body'))
                        ->success()
                        ->send();
                } catch (\Exception $e) {
                    Notification::make()
                        ->title(trans('account.accounts.import.error'))
                        ->body(trans('account.accounts.import.error-body'))
                        ->danger()
                        ->send();
                }

            })
            ->color('warning')
            ->icon('heroicon-o-arrow-up-on-square');
    }
}
