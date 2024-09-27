<?php

namespace App\Filament\Resources;

use App\Components\AccountColumn;
use App\Components\TypeColumn;
use App\Filament\Resources\AccountRequestResource\Pages;
use App\Filament\Resources\AccountRequestResource\RelationManagers;
use App\Models\AccountRequest;
use App\Models\Type;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AccountRequestResource extends Resource
{
    protected static ?string $model = AccountRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-cursor-arrow-ripple';

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return trans('account.group');
    }

    public static function getNavigationLabel(): string
    {
        return trans('account.requests.label');
    }

    public static function getPluralLabel(): ?string
    {
        return trans('account.requests.label');
    }

    public static function form(Form $form): Form
    {
        $payload = [];
        $columns = [];

        $columns[] = Forms\Components\Select::make('type')
            ->label(trans('account.requests.columns.type'))
            ->searchable()
            ->options(Type::where('for', 'account-requests')->where('type', 'types')->get()->pluck('name', 'key')->toArray());

        $columns[] = Forms\Components\Select::make('status')
            ->label(trans('account.requests.columns.status'))
            ->searchable()
            ->options(Type::where('for', 'account-requests')->where('type', 'status')->get()->pluck('name', 'key')->toArray())
            ->default('pending');

        $columns[] = Forms\Components\Toggle::make('is_approved')
            ->label(trans('account.requests.columns.is_approved'));

        return $form->schema($columns);
    }

    public static function table(Table $table): Table
    {
        $columns = [];

        $columns[] = AccountColumn::make('account.id')
            ->label(trans('account.requests.columns.account'))
            ->sortable();

        $columns[] = Tables\Columns\TextColumn::make('user.name')
            ->label(trans('account.requests.columns.user'))
            ->sortable();

        $columns[] = TypeColumn::make('type')
            ->label(trans('account.requests.columns.type'))
            ->searchable();
        $columns[] = TypeColumn::make('status')
            ->label(trans('account.requests.columns.status'))
            ->searchable();

        $columns = array_merge($columns, [
            Tables\Columns\IconColumn::make('is_approved')
                ->label(trans('account.requests.columns.is_approved'))
                ->boolean(),
            Tables\Columns\TextColumn::make('is_approved_at')
                ->label(trans('account.requests.columns.is_approved_at'))
                ->dateTime()
                ->sortable(),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ]);

        return $table
            ->columns($columns)
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->defaultSort('created_at', 'desc')
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AccountRequestMetaManager::make(),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAccountRequests::route('/'),
            'edit' => Pages\EditAccountRequest::route('/{record}/edit'),
        ];
    }
}
