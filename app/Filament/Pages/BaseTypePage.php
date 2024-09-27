<?php

namespace App\Filament\Pages;

use App\Components\TypeColumn;
use App\Models\Type;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use TomatoPHP\FilamentIcons\Components\IconPicker;
use TomatoPHP\FilamentTranslationComponent\Components\Translation;

class BaseTypePage extends Page implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public array $data = [];

    protected static string $view = 'pages.types';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function getBackUrl(): string
    {
        return url()->previous();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('create')
                ->label(trans('types.create'))
                ->form([
                    Grid::make([
                        'md' => 2,
                        'sm' => 1,
                    ])->schema([
                        Translation::make('name')
                            ->columnSpanFull()
                            ->label(trans('types.form.name')),
                        TextInput::make('key')
                            ->columnSpanFull()
                            ->required()
                            ->label(trans('types.form.key')),
                        IconPicker::make('icon')
                            ->label(trans('types.form.icon')),
                        ColorPicker::make('color')
                            ->label(trans('types.form.color')),
                    ]),
                ])
                ->action(function (array $data) {
                    $data['for'] = $this->getFor();
                    $data['type'] = $this->getType();
                    Type::create($data);

                    Notification::make()
                        ->title(trans('types.notification.create.title'))
                        ->body(trans('types.notification.create.title'))
                        ->success()
                        ->send();
                }),
            Action::make('back')
                ->label(trans('types.back'))
                ->url(fn() => $this->getBackUrl())
                ->color('warning')
                ->icon('heroicon-s-arrow-left'),
        ];
    }

    public function getType(): string
    {
        return 'status';
    }

    public function getFor(): string
    {
        return 'types';
    }

    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected array $types = [];

    public function getTypes(): array
    {
        return [];
    }

    public function mount(): void
    {
        foreach ($this->getTypes() as $type) {
            $exists = Type::query()
                ->where('for', $this->getFor())
                ->where('type', $this->getType())
                ->where('key', $type->key)
                ->first();
            if (!$exists) {
                $type->for = $this->getFor();
                $type->type = $this->getType();
                $exists = Type::create($type->toArray());
            }
        }
    }

    public function getTitle(): string
    {
        return trans('types.base.title');
    }

    public function getCreateAction(): bool
    {
        return true;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Type::query()
                    ->where('for', $this->getFor())
                    ->where('type', $this->getType())
            )
            ->paginated(false)
            ->columns([
                TypeColumn::make('key')
                    ->for($this->getFor())
                    ->type($this->getType())
                    ->label(trans('types.form.key')),
            ])
            ->actions([
                \Filament\Tables\Actions\Action::make('edit')
                    ->label(trans('types.edit'))
                    ->tooltip(trans('types.edit'))
                    ->form([
                        Grid::make([
                            'md' => 2,
                            'sm' => 1,
                        ])->schema([
                            Translation::make('name')
                                ->columnSpanFull()
                                ->label(trans('types.form.name')),
                            IconPicker::make('icon')
                                ->label(trans('types.form.icon')),
                            ColorPicker::make('color')
                                ->label(trans('types.form.color')),
                        ]),
                    ])
                    ->extraModalFooterActions([
                        \Filament\Tables\Actions\Action::make('deleteType')
                            ->requiresConfirmation()
                            ->color('danger')
                            ->label(trans('types.delete'))
                            ->cancelParentActions()
                            ->action(function (array $data, $record) {
                                foreach ($this->getTypes() as $getType) {
                                    if ($getType->key == $record->key) {
                                        Notification::make()
                                            ->title(trans('types.notification.error.title'))
                                            ->body(trans('types.notification.error.body'))
                                            ->danger()
                                            ->send();

                                        return;
                                    }
                                }

                                $record->delete();
                                Notification::make()
                                    ->title(trans('types.notification.delete.title'))
                                    ->body(trans('types.notification.delete.body'))
                                    ->success()
                                    ->send();
                            }),
                    ])
                    ->fillForm(fn($record) => $record->toArray())
                    ->icon('heroicon-s-pencil-square')
                    ->iconButton()
                    ->action(function (array $data, Type $type) {
                        $type->update($data);
                        Notification::make()
                            ->title(trans('types.notification.edit.title'))
                            ->body(trans('types.notification.edit.body'))
                            ->success()
                            ->send();
                    }),
            ]);
    }
}
