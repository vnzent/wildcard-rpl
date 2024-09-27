<?php

namespace App\Filament\Pages\EditProfile;

use App\Forms\BrowserSessionsForm;
use Filament\Forms\Form;

trait HasBrowserSessions
{
    public function browserSessionsForm(Form $form): Form
    {
        return $form
            ->schema(BrowserSessionsForm::get());
    }
}
