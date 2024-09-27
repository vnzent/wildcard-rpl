<?php

namespace App\Filament\Resources\TypeResource\Pages;

use App\Filament\Resources\TypeResource;
use App\Models\Type;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;

class ListTypes extends ManageRecords
{
    use ManageRecords\Concerns\Translatable;

//    #[Reactive]
    public ?string $activeLocale = null;

    public function getTitle(): string
    {
        return trans('types.title');
    }

    protected static string $resource = TypeResource::class;

    public static function getTranslatableLocales(): array
    {
        return ['en', 'ar'];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label(trans('types.create'))
                ->using(function (array $data) {
                    $checkExistsType = Type::query()
                        ->where('key', $data['key'])
                        ->where('for', $data['for'])
                        ->where('type', $data['type'])
                        ->first();

                    if ($checkExistsType) {
                        Notification::make()
                            ->title(trans('types.exists'))
                            ->danger()
                            ->send();

                        return $checkExistsType;

                    } else {
                        $type = Type::create($data);

                        Notification::make()
                            ->title(trans('types.success'))
                            ->success()
                            ->send();

                        return $type;
                    }
                })
                ->successNotification(null),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
