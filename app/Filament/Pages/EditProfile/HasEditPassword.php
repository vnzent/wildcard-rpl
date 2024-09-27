<?php

namespace App\Filament\Pages\EditProfile;

use App\Forms\EditPasswordForm;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Form;
use Filament\Support\Exceptions\Halt;

trait HasEditPassword
{
    public function editPasswordForm(Form $form): Form
    {
        return $form
            ->schema(EditPasswordForm::get())
            ->model($this->getUser())
            ->statePath('passwordData');
    }

    protected function getUpdatePasswordFormActions(): array
    {
        return [
            Action::make('updatePasswordAction')
                ->label(trans('account.save'))
                ->submit('editPasswordForm'),
        ];
    }

    public function updatePassword(): void
    {
        try {
            $data = $this->editPasswordForm->getState();

            $this->handleRecordUpdate($this->getUser(), $data);
        } catch (Halt $exception) {
            return;
        }

        if (request()->hasSession() && array_key_exists('password', $data)) {
            request()->session()->put([
                'password_hash_'.Filament::getAuthGuard() => $data['password'],
            ]);
        }

        $this->editPasswordForm->fill();

        $this->sendSuccessNotification();
    }
}
