<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormResource\Pages;
use App\Filament\Resources\FormResource\RelationManagers;
use App\Models\Form as FormModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class FormResource extends Resource
{
    use Translatable;

    protected static ?string $model = FormModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    public static function getNavigationGroup(): ?string
    {
        return trans('cms.content.group');
    }

    public static function getPluralLabel(): ?string
    {
        return trans('cms.forms.title');
    }

    public static function getLabel(): ?string
    {
        return trans('cms.forms.single');
    }

    public static function getNavigationLabel(): string
    {
        return trans('cms.forms.title');
    }

    public static function form(Form $form): Form
    {
        $formSchema = [
            Forms\Components\Select::make('type')
                ->label(trans('cms.forms.columns.type'))
                ->searchable()
                ->options([
                    'page' => 'Page',
                    'modal' => 'Modal',
                    'slideover' => 'Slideover',
                ])
                ->default('page'),
            Forms\Components\Select::make('method')
                ->label(trans('cms.forms.columns.method'))
                ->searchable()
                ->options([
                    'POST' => 'POST',
                    'GET' => 'GET',
                    'PUT' => 'PUT',
                    'DELETE' => 'DELETE',
                    'PATCH' => 'PATCH',
                ])
                ->default('POST'),
            Forms\Components\TextInput::make('title')
                ->label(trans('cms.forms.columns.title')),
            Forms\Components\TextInput::make('key')
                ->label(trans('cms.forms.columns.key'))
                ->default(Str::random(6))
                ->unique(ignoreRecord: true)
                ->required()
                ->maxLength(255),
            Forms\Components\Textarea::make('description')
                ->label(trans('cms.forms.columns.description'))
                ->columnSpanFull(),
            Forms\Components\TextInput::make('endpoint')
                ->label(trans('cms.forms.columns.endpoint'))
                ->columnSpanFull()
                ->maxLength(255)
                ->default('/'),
            Forms\Components\Toggle::make('is_active')
                ->label(trans('cms.forms.columns.is_active')),
        ];

        return $form
            ->schema(fn ($record) => $record ? [
                Forms\Components\Section::make(trans('cms.forms.section.information'))
                    ->collapsible()
                    ->collapsed(fn ($record) => $record)
                    ->schema($formSchema),
            ] : $formSchema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label(trans('cms.forms.columns.type'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->label(trans('cms.forms.columns.title'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('key')
                    ->label(trans('cms.forms.columns.key'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('endpoint')
                    ->label(trans('cms.forms.columns.endpoint'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('method')
                    ->label(trans('cms.forms.columns.method'))
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(trans('cms.forms.columns.is_active'))
                    ->boolean(),
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
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\FormFieldsRelation::class,
            RelationManagers\FormRequestsRelation::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListForms::route('/'),
            'edit' => Pages\EditForm::route('/{record}/edit'),
        ];
    }
}
