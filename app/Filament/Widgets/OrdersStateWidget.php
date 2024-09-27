<?php

namespace App\Filament\Widgets;

use App\Filament\State\EcommerceState;
use App\Models\Order;
use App\Models\Type;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Flowframe\Trend\Trend;

class OrdersStateWidget extends BaseWidget
{
    protected static string $view = 'filament-widgets::stats-overview-widget';

    protected function getStats(): array
    {
        $orderQuery = Order::query();
        $orderStates = Type::query()
            ->where('for', 'orders')
            ->where('type', 'status')
            ->get();

        $states = [];
        foreach ($orderStates as $item) {
            $trend = Trend::query((clone $orderQuery)->where('status', $item->key))
                ->interval('day')
                ->dateColumn('created_at')
                ->between(
                    now()->subMonth(),
                    now()
                )
                ->count();
            $states[] = EcommerceState::make(trans('ecommerce.widget.orders').' '.$item->name, (clone $orderQuery)->where('status', $item->key)->count())
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->value((clone $orderQuery)->where('status', $item->key)->count())
                ->chart($trend->pluck('aggregate')->toArray())
                ->color($item->color)
                ->icon($item->icon);
        }

        return $states;
    }
}
