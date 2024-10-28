<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Filament\Traits\RedirectToIndexAfterCreate;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    use RedirectToIndexAfterCreate;

    protected static string $resource = UserResource::class;
}
