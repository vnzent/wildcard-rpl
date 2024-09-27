<?php

namespace App\Filament\Pages\EditProfile;

use App\Forms\DeleteAccountForm;
use Filament\Forms\Form;

trait HasDeleteAccount
{
    public function deleteAccountForm(Form $form): Form
    {
        return $form
            ->schema(DeleteAccountForm::get())
            ->model($this->getUser())
            ->statePath('deleteAccountData');
    }
}
