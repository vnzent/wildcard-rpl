<?php

namespace App\Filament\Pages;

use App\Filament\Pages\EditProfile\HasBrowserSessions;
use App\Filament\Pages\EditProfile\HasDeleteAccount;
use App\Filament\Pages\EditProfile\HasEditPassword;
use App\Filament\Pages\EditProfile\HasEditProfile;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class EditProfile extends Page implements HasForms
{
    use HasBrowserSessions;
    use HasDeleteAccount;
    use HasEditPassword;
    use HasEditProfile;
    use InteractsWithForms;

    protected static string $view = 'teams.edit-profile';

    protected ?string $maxWidth = '6xl';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function getTitle(): string
    {
        return trans('account.profile.title');
    }

    public static function getNavigationLabel(): string
    {
        return trans('account.profile.title');
    }

    public static function canAccess(): bool
    {
        return true;
    }

    public static function shouldShowDeleteAccountForm()
    {
        return true;
    }

    public static function shouldShowBrowserSessionsForm()
    {
        return true;
    }

    public static function shouldShowSanctumTokens()
    {
        return true;
    }

    public ?array $profileData = [];

    public ?array $passwordData = [];

    public function mount(): void
    {
        $this->fillForms();
    }

    protected function getForms(): array
    {
        return [
            'editProfileForm',
            'editPasswordForm',
            'deleteAccountForm',
            'browserSessionsForm',
        ];
    }

    protected function fillForms(): void
    {
        $data = $this->getUser()->attributesToArray();

        $this->editProfileForm->fill($data);
        $this->editPasswordForm->fill();
    }

    public function getUser()
    {
        return auth(filament()->getPlugin('filament-saas-accounts')->authGuard)->user();
    }

    public function sendSuccessNotification()
    {
        Notification::make()
            ->title('Success')
            ->success()
            ->send();
    }
}
