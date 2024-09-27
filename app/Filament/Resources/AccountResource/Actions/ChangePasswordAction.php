<?php

namespace App\Filament\Resources\AccountResource\Actions;

use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;

class ChangePasswordAction
{
    public static function make(): Action
    {
        return Action::make('password')
            ->label(trans('account.accounts.actions.password'))
            ->icon('heroicon-s-lock-closed')
            ->iconButton()
            ->tooltip(trans('account.accounts.actions.password'))
            ->color('danger')
            ->form([
                Forms\Components\TextInput::make('password')
                    ->label(trans('account.accounts.coulmns.password'))
                    ->password()
                    ->required()
                    ->confirmed()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password_confirmation')
                    ->label(trans('account.accounts.coulmns.password_confirmation'))
                    ->password()
                    ->required()
                    ->maxLength(255),
            ])
            ->action(function (array $data, $record) {
                $record->password = bcrypt($data['password']);
                $record->save();

                Notification::make()
                    ->title('Account Password Changed')
                    ->body('Account password changed successfully')
                    ->success()
                    ->send();
            });
    }
}
