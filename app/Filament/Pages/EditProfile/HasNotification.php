<?php

namespace App\Filament\Pages\EditProfile;

use Filament\Notifications\Notification;

trait HasNotification
{
    private function sendSuccessNotification(): void
    {
        Notification::make()
            ->success()
            ->title(trans('account.saved_successfully'))
            ->send();

        $data = $this->getUser()->attributesToArray();

        $this->editProfileForm->fill($data);
        $this->editPasswordForm->fill();
    }
}
