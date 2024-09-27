<?php

namespace App\Filament\Resources\AccountResource\Actions;

use App\Facades\Accounts;
use Filament\Tables;
use TomatoPHP\FilamentHelpers\Contracts\ActionsBuilder;

class AccountsTableActions extends ActionsBuilder
{
    public function actions(): array
    {
        $actions = collect();

        $actions->push(AccountImpersonateAction::make());
        $actions->push(ChangePasswordAction::make());
        $actions->push(AccountNotificationsAction::make());

        //Merge Default Actions
        $actions = $actions->merge([
            Tables\Actions\EditAction::make()
                ->iconButton()
                ->tooltip(trans('account.accounts.actions.edit')),
            Tables\Actions\DeleteAction::make()
                ->iconButton()
                ->tooltip(trans('account.accounts.actions.delete')),
            Tables\Actions\ForceDeleteAction::make()
                ->iconButton()
                ->tooltip(trans('account.accounts.actions.force_delete')),
            Tables\Actions\RestoreAction::make()
                ->iconButton()
                ->tooltip(trans('account.accounts.actions.restore')),
        ]);

        //Merge Provider Actions
        $actions = $actions->merge(Accounts::loadActions());

        return $actions->toArray();
    }
}
