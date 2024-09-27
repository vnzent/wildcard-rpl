<?php

namespace App\Filament\Pages\EditProfile;

use App\Forms\EditProfileForm;
use Filament\Actions\Action;
use Filament\Forms\Form;
use Filament\Support\Exceptions\Halt;
use Illuminate\Database\Eloquent\Model;

trait HasEditProfile
{
    public function editProfileForm(Form $form): Form
    {
        return $form
            ->schema(EditProfileForm::get())
            ->model($this->getUser())
            ->statePath('profileData');
    }

    protected function getUpdateProfileFormActions(): array
    {
        return [
            Action::make('updateProfileAction')
                ->label(trans('account.save'))
                ->submit('editProfileForm'),
        ];
    }

    public function updateProfile(): void
    {
        try {
            $data = $this->editProfileForm->getState();

            $this->handleRecordUpdate($this->getUser(), $data);
        } catch (Halt $exception) {
            return;
        }

        $this->sendSuccessNotification();
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);

        return $record;
    }
}
