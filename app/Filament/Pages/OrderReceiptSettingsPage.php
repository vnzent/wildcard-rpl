<?php

namespace App\Filament\Pages;

use App\Settings\OrderingSettings;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Toggle;
use Filament\Pages\SettingsPage;

class OrderReceiptSettingsPage extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog';

    protected static string $settings = OrderingSettings::class;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    protected function getActions(): array
    {
        $tenant = Filament::getTenant();
        if ($tenant) {
            return [
                Action::make('back')->action(fn () => redirect()->route('filament.'.filament()->getCurrentPanel()->getId().'.pages.settings-hub', $tenant))->color('danger')->label(trans('filament-settings-hub::messages.back')),
            ];
        }

        return [
            Action::make('back')->action(fn () => redirect()->route('filament.'.filament()->getCurrentPanel()->getId().'.pages.settings-hub'))->color('danger')->label(trans('filament-settings-hub::messages.back')),
        ];
    }

    public function getTitle(): string
    {
        return trans('ecommerce.settings.receipt.title');
    }

    protected function getFormSchema(): array
    {
        return [
            Grid::make(['default' => 1])->schema([
                Toggle::make('ordering_show_company_data')
                    ->label(trans('ecommerce.settings.receipt.columns.ordering_show_company_data'))
                    ->hint(config('filament-settings-hub.show_hint') ? 'setting("ordering_show_company_data")' : null),
                Toggle::make('ordering_show_company_logo')
                    ->label(trans('ecommerce.settings.receipt.columns.ordering_show_company_logo'))
                    ->hint(config('filament-settings-hub.show_hint') ? 'setting("ordering_show_company_logo")' : null),
                Toggle::make('ordering_show_branch_data')
                    ->label(trans('ecommerce.settings.receipt.columns.ordering_show_branch_data'))
                    ->hint(config('filament-settings-hub.show_hint') ? 'setting("ordering_show_branch_data")' : null),
                Toggle::make('ordering_show_tax_number')
                    ->label(trans('ecommerce.settings.receipt.columns.ordering_show_tax_number'))
                    ->hint(config('filament-settings-hub.show_hint') ? 'setting("ordering_show_tax_number")' : null),
                Toggle::make('ordering_show_registration_number')
                    ->label(trans('ecommerce.settings.receipt.columns.ordering_show_registration_number'))
                    ->hint(config('filament-settings-hub.show_hint') ? 'setting("ordering_show_registration_number")' : null),
            ]),
        ];
    }
}
