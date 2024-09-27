<?php

namespace App\Providers;

use App\Facades\CMS;
use App\Filament\Pages\OrderReceiptSettingsPage;
use App\Filament\Pages\OrderSettingsPage;
use App\Filament\Pages\OrderStatusSettingsPage;
use App\Services\BuildAuth;
use App\Services\CMSServices;
use App\Services\Contracts\CmsType;
use App\Services\EcommerceServices;
use App\Services\FilamentAccountsServices;
use App\Services\TypesRegister;
use Illuminate\Support\ServiceProvider;
use TomatoPHP\FilamentSettingsHub\Facades\FilamentSettingsHub;
use TomatoPHP\FilamentSettingsHub\Services\Contracts\SettingHold;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind('types', function () {
            return new TypesRegister;
        });

        $this->app->bind('ecommerce', function () {
            return new EcommerceServices;
        });

        $this->app->bind('cms', function () {
            return new CMSServices;
        });

        $this->app->bind('accounts', function () {
            return new FilamentAccountsServices;
        });

        $this->app->bind('accounts-auth', function () {
            return new BuildAuth;
        });
    }

    public function boot(): void
    {
        CMS::types()->register([
            CmsType::make('product')
                ->label('Product')
                ->color('primary')
                ->icon('heroicon-o-shopping-cart')
                ->sub([
                    CmsType::make('category')
                        ->label('Category')
                        ->color('primary')
                        ->icon('heroicon-o-rectangle-group'),
                    CmsType::make('tag')
                        ->label('Tag')
                        ->color('primary')
                        ->icon('heroicon-o-tag'),
                ]),
        ]);

        FilamentSettingsHub::register([
            SettingHold::make()
                ->label('ecommerce.settings.orders.title')
                ->icon('heroicon-o-building-storefront')
                ->route(OrderSettingsPage::getRouteName())
                ->description('ecommerce.settings.orders.description')
                ->group('ecommerce.settings.group'),
            SettingHold::make()
                ->label('ecommerce.settings.status.title')
                ->icon('heroicon-o-check-circle')
                ->route(OrderStatusSettingsPage::getRouteName())
                ->description('ecommerce.settings.status.description')
                ->group('ecommerce.settings.group'),
            SettingHold::make()
                ->label('ecommerce.settings.receipt.title')
                ->icon('heroicon-o-printer')
                ->route(OrderReceiptSettingsPage::getRouteName())
                ->description('ecommerce.settings.receipt.description')
                ->group('ecommerce.settings.group'),
        ]);
    }
}
