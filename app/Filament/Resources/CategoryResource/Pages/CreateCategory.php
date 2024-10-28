<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use App\Filament\Traits\RedirectToIndexAfterCreate;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    use RedirectToIndexAfterCreate;

    protected static string $resource = CategoryResource::class;
}
