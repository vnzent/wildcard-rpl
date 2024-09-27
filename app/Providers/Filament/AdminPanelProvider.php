<?php

namespace App\Providers\Filament;

use App\Filament\Pages\OrderReceiptSettingsPage;
use App\Filament\Pages\OrderSettingsPage;
use App\Filament\Pages\OrderStatusSettingsPage;
use App\Filament\Pages\Pos;
use App\Filament\Resources\CompanyResource;
use App\Filament\Resources\CouponResource;
use App\Filament\Resources\GiftCardResource;
use App\Filament\Resources\OrderResource;
use App\Filament\Resources\ProductResource;
use App\Filament\Resources\ReferralCodeResource;
use App\Filament\Resources\ShippingVendorResource;
use App\Filament\Resources\TypeResource;
use App\Filament\Widgets\OrderPaymentMethodChart;
use App\Filament\Widgets\OrderSourceChart;
use App\Filament\Widgets\OrdersStateWidget;
use App\Filament\Widgets\OrderStateChart;
use App\Filament\Widgets\POSStateWidget;
use Exception;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\SpatieLaravelTranslatablePlugin;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    /**
     * @throws Exception
     */
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,

                Pos::class,

                OrderSettingsPage::class,
                OrderStatusSettingsPage::class,
                OrderReceiptSettingsPage::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,

                POSStateWidget::class,

                OrdersStateWidget::class,
                OrderPaymentMethodChart::class,
                OrderSourceChart::class,
                OrderStateChart::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->resources([
                TypeResource::class,

                CompanyResource::class,
                ProductResource::class,
                OrderResource::class,
                ShippingVendorResource::class,
                CouponResource::class,
                GiftCardResource::class,
                ReferralCodeResource::class,
            ])
            ->plugin(SpatieLaravelTranslatablePlugin::make()->defaultLocales(['en', 'ar']))
            ->plugin(FilamentSettingsHubPlugin::make());
    }
}
