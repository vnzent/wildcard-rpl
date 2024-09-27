<?php

namespace App\Filament\Resources\ShippingVendorResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ShippingDeliveryBoys extends RelationManager
{
    protected static string $relationship = 'deliveries';

    public static function getLabel(): ?string
    {
        return trans('ecommerce.deliveries.single');
    }

    public static function getModelLabel(): ?string
    {
        return trans('ecommerce.deliveries.single');
    }

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return trans('ecommerce.deliveries.title');
    }

    protected static function getPluralModelLabel(): ?string
    {
        return trans('ecommerce.deliveries.title');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(trans('ecommerce.deliveries.columns.name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->label(trans('ecommerce.deliveries.columns.phone'))
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->label(trans('ecommerce.deliveries.columns.address'))
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_activated')
                    ->label(trans('ecommerce.deliveries.columns.is_activated')),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(trans('ecommerce.deliveries.columns.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(trans('ecommerce.deliveries.columns.phone'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->label(trans('ecommerce.deliveries.columns.address'))
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('is_activated')
                    ->label(trans('ecommerce.deliveries.columns.is_activated')),
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
}
