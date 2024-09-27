<?php

namespace App\Providers;

use App\Services\EcommerceServices;
use App\Services\TypesRegister;
use Illuminate\Support\ServiceProvider;

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
    }

    public function boot(): void
    {
        FilamentCMS::types()->register([
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
                ->label('filament-ecommerce::messages.settings.orders.title')
                ->icon('heroicon-o-building-storefront')
                ->route(OrderSettingsPage::getRouteName())
                ->description('filament-ecommerce::messages.settings.orders.description')
                ->group('filament-ecommerce::messages.settings.group'),
            SettingHold::make()
                ->label('filament-ecommerce::messages.settings.status.title')
                ->icon('heroicon-o-check-circle')
                ->route(OrderStatusSettingsPage::getRouteName())
                ->description('filament-ecommerce::messages.settings.status.description')
                ->group('filament-ecommerce::messages.settings.group'),
            SettingHold::make()
                ->label('filament-ecommerce::messages.settings.receipt.title')
                ->icon('heroicon-o-printer')
                ->route(OrderReceiptSettingsPage::getRouteName())
                ->description('filament-ecommerce::messages.settings.receipt.description')
                ->group('filament-ecommerce::messages.settings.group'),
        ]);
    }
}
