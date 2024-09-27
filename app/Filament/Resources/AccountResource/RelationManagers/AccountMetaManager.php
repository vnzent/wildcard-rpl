<?php

namespace App\Filament\Resources\AccountResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class AccountMetaManager extends RelationManager
{
    protected static string $relationship = 'accountsMetas';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return trans('account.meta.label');
    }

    public static function getLabel(): ?string
    {
        return trans('account.meta.label');
    }

    public static function getPluralLabel(): ?string
    {
        return trans('account.meta.label');
    }

    public static function getModelLabel(): ?string
    {
        return trans('account.meta.label');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('key')
                    ->label(trans('account.meta.columns.key'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('value')
                    ->label(trans('account.meta.columns.value')),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label(trans('account.meta.columns.key'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('value')
                    ->label(trans('account.meta.columns.value'))
                    ->view('filament-accounts::table-columns.value'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
