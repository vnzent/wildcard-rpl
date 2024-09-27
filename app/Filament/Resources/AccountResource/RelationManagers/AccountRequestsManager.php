<?php

namespace App\Filament\Resources\AccountResource\RelationManagers;

use App\Components\TypeColumn;
use App\Models\Type;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class AccountRequestsManager extends RelationManager
{
    protected static string $relationship = 'requests';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return trans('account.requests.label');
    }

    public static function getLabel(): ?string
    {
        return trans('account.requests.label');
    }

    public static function getPluralLabel(): ?string
    {
        return trans('account.requests.label');
    }

    public static function getModelLabel(): ?string
    {
        return trans('account.requests.label');
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('type')
                ->label(trans('account.requests.columns.type'))
                ->searchable()
                ->options(Type::where('for', 'contacts')->where('type', 'type')->get()->pluck('name', 'key')->toArray()),
            Forms\Components\Select::make('status')
                ->label(trans('account.requests.columns.status'))
                ->searchable()
                ->options(Type::where('for', 'contacts')->where('type', 'status')->get()->pluck('name', 'key')->toArray())
                ->default('pending'),

            Forms\Components\Toggle::make('is_approved')
                ->label(trans('account.requests.columns.is_approved')),
        ]);
    }

    public function table(Table $table): Table
    {
        $columns = [];

        $columns[] = Tables\Columns\TextColumn::make('user.name')
            ->label(trans('account.requests.columns.user'))
            ->sortable();

        if (filament('filament-accounts')->useTypes) {
            $columns[] = TypeColumn::make('type')
                ->label(trans('account.requests.columns.type'))
                ->searchable();
            $columns[] = TypeColumn::make('status')
                ->label(trans('account.requests.columns.status'))
                ->searchable();
        } else {
            $columns[] = Tables\Columns\TextColumn::make('type')
                ->label(trans('account.requests.columns.type'))
                ->searchable();
            $columns[] = Tables\Columns\TextColumn::make('status')
                ->label(trans('account.requests.columns.status'))
                ->searchable();
        }

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

            ])
            ->actions([
                Tables\Actions\Action::make('edit')
                    ->icon('heroicon-s-pencil-square')
                    ->url(fn ($record) => route('filament.'.filament()->getCurrentPanel()->getId().'.resources.account-requests.edit', $record)),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
