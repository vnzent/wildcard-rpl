<?php

namespace App\Filament\Traits;

trait RedirectToIndexAfterCreate
{
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
