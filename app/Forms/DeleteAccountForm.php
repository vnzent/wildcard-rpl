<?php

namespace App\Forms;

use Filament\Forms;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Section;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;

class DeleteAccountForm
{
    public static function get(): array
    {
        return [
            Section::make(trans('account.profile.delete.delete_account'))
                ->description(trans('account.profile.delete.delete_account_description'))
                ->schema([
                    Forms\Components\ViewField::make('deleteAccount')
                        ->label(__('Delete Account'))
                        ->hiddenLabel()
                        ->view('filament-accounts::forms.components.delete-account-description'),
                    Actions::make([
                        Actions\Action::make('deleteAccount')
                            ->label(trans('account.profile.delete.delete_account'))
                            ->icon('heroicon-m-trash')
                            ->color('danger')
                            ->requiresConfirmation()
                            ->modalHeading(trans('account.profile.delete.delete_account'))
                            ->modalDescription(trans('account.profile.delete.are_you_sure'))
                            ->modalSubmitActionLabel(trans('account.profile.delete.yes_delete_it'))
                            ->form([
                                Forms\Components\TextInput::make('password')
                                    ->password()
                                    ->revealable()
                                    ->label(trans('account.profile.delete.password'))
                                    ->required(),
                            ])
                            ->action(function (array $data) {

                                if (! Hash::check($data['password'], auth('accounts')->user()->password)) {
                                    self::sendErrorDeleteAccount(trans('account.profile.delete.incorrect_password'));

                                    return;
                                }

                                auth('accounts')->user()?->update([
                                    'is_active' => false,
                                ]);

                                auth('accounts')->user()?->delete();
                            }),
                    ]),
                ]),
        ];
    }

    public static function sendErrorDeleteAccount(string $message): void
    {
        Notification::make()
            ->danger()
            ->title($message)
            ->send();
    }
}
