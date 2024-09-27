<?php

namespace App\Filament\Resources\FormResource\RelationManagers;

use App\Models\FormRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class FormRequestsRelation extends RelationManager
{
    protected static string $relationship = 'requests';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return trans('cms.forms.requests.title');
    }

    public static function getLabel(): ?string
    {
        return trans('cms.forms.requests.title');
    }

    public static function getModelLabel(): ?string
    {
        return trans('cms.forms.requests.single');
    }

    public static function getPluralLabel(): ?string
    {
        return trans('cms.forms.requests.title');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('status')
                    ->label(trans('cms.forms.requests.columns.status'))
                    ->searchable()
                    ->options([
                        'pending' => trans('cms.forms.requests.columns.pending'),
                        'processing' => trans('cms.forms.requests.columns.processing'),
                        'completed' => trans('cms.forms.requests.columns.completed'),
                        'cancelled' => trans('cms.forms.requests.columns.cancelled'),
                    ])
                    ->columnSpanFull()
                    ->default('pending'),
            ]);
    }

    public function infolist(Infolist $infolist): Infolist
    {

        return $infolist->schema([
            TextEntry::make('description')
                ->label(trans('cms.forms.requests.columns.description'))
                ->columnSpanFull(),
            TextEntry::make('time')
                ->label(trans('cms.forms.requests.columns.time')),
            TextEntry::make('date')
                ->label(trans('cms.forms.requests.columns.date')),
            KeyValueEntry::make('payload')
                ->label(trans('cms.forms.requests.columns.payload'))
                ->columnSpanFull()
                ->schema(function (FormRequest $record) {
                    $getEntryText = [];
                    foreach ($record->payload as $key => $value) {
                        $field = $record->form->fields->where('key', $key)->first();
                        $getEntryText[] = TextEntry::make($key)
                            ->label($field->label ?? str($key)->title())
                            ->default($value)
                            ->columnSpanFull();
                    }

                    return $getEntryText;
                })
                ->columns(2),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('status')
                    ->label(trans('cms.forms.requests.columns.status'))
                    ->badge()
                    ->state(fn ($record) => match ($record->status) {
                        'pending' => trans('cms.forms.requests.columns.pending'),
                        'processing' => trans('cms.forms.requests.columns.processing'),
                        'completed' => trans('cms.forms.requests.columns.completed'),
                        'cancelled' => trans('cms.forms.requests.columns.cancelled'),
                        default => $record->status,
                    })
                    ->icon(fn ($record) => match ($record->status) {
                        'pending' => 'heroicon-s-rectangle-stack',
                        'processing' => 'heroicon-s-arrow-path',
                        'completed' => 'heroicon-s-check-circle',
                        'cancelled' => 'heroicon-s-x-circle',
                        default => 'heroicon-s-x-circle',
                    })
                    ->color(fn ($record) => match ($record->status) {
                        'pending' => 'info',
                        'processing' => 'warning',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'secondary',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label(trans('cms.forms.requests.columns.description')),
                Tables\Columns\TextColumn::make('date')
                    ->label(trans('cms.forms.requests.columns.date'))
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('time')
                    ->label(trans('cms.forms.requests.columns.time')),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label(trans('cms.forms.requests.columns.status'))
                    ->searchable()
                    ->options([
                        'pending' => trans('cms.forms.requests.columns.pending'),
                        'processing' => trans('cms.forms.requests.columns.processing'),
                        'completed' => trans('cms.forms.requests.columns.completed'),
                        'cancelled' => trans('cms.forms.requests.columns.cancelled'),
                    ])
                    ->columnSpanFull(),
            ])
            ->defaultSort('created_at', 'desc')
            ->groups([
                Tables\Grouping\Group::make('status'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
