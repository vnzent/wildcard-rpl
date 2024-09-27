<?php

namespace App\Filament\Resources\AccountResource\Tables;

use App\Components\AccountColumn;
use App\Components\TypeColumn;
use App\Filament\Resources\AccountResource\Actions\AccountsTableActions;
use App\Filament\Resources\AccountResource\Actions\ExportAccountsAction;
use App\Filament\Resources\AccountResource\Actions\ImportAccountsAction;
use App\Filament\Resources\AccountResource\Filters\AccountsFilters;
use Filament\Tables;
use Filament\Tables\Table;
use TomatoPHP\FilamentHelpers\Contracts\TableBuilder;

class AccountsTable extends TableBuilder
{
    public function table(Table $table): Table
    {
        $colums = collect([]);

        $colums->push(
            AccountColumn::make('id')
                ->label(trans('account.accounts.coulmns.id')),
            Tables\Columns\TextColumn::make('name')
                ->label(trans('account.accounts.coulmns.name'))
                ->toggleable(isToggledHiddenByDefault: true)
                ->sortable()
                ->searchable()
        );

        $colums->push(
            TypeColumn::make('type')
                ->label(trans('account.accounts.coulmns.type'))
                ->toggleable()
                ->sortable()
                ->searchable()
        );

        $colums = $colums->merge([
            Tables\Columns\TextColumn::make('email')
                ->label(trans('account.accounts.coulmns.email'))
                ->toggleable(isToggledHiddenByDefault: true)
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('phone')
                ->label(trans('account.accounts.coulmns.phone'))
                ->toggleable(isToggledHiddenByDefault: true)
                ->sortable()
                ->searchable(),
        ]);

        //Can Login
        if (filament('account')->canLogin) {
            $colums->push(
                Tables\Columns\IconColumn::make('is_login')
                    ->label(trans('account.accounts.coulmns.is_login'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->boolean()
            );
        }

        //Can Blocked
        if (filament('account')->canBlocked) {
            $colums->push(
                Tables\Columns\IconColumn::make('is_active')
                    ->label(trans('account.accounts.coulmns.is_active'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable()
                    ->boolean()
            );
        }

        //Can Verified
        $colums = $colums->merge([
            Tables\Columns\TextColumn::make('deleted_at')
                ->sortable()
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('created_at')
                ->sortable()
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('updated_at')
                ->sortable()
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ]);

        $actions = collect([]);

        $actions->push(ExportAccountsAction::make());
        $actions->push(ImportAccountsAction::make());

        return $table
            ->headerActions($actions->toArray())
            ->columns($colums->toArray())
            ->filters(config('account.accounts.filters') ? config('account.accounts.filters')::make() : AccountsFilters::make())
            ->actions(config('account.accounts.actions') ? config('account.accounts.actions')::make() : AccountsTableActions::make())
            ->defaultSort('id', 'desc')
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }
}
