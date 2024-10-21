<?php

namespace App\Filament\Resources\ProductResource\Widgets;

use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LowStockAlertWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $threshold = 10;
        $lowStockProducts = Product::where('quantity', '<', $threshold)
            ->pluck('name');

        $lowStockCount = Product::where('quantity', '<', $threshold)->count();

        return [
            Stat::make('Low Stock Products', $lowStockCount)
                ->description('Products with less than 10 in stock')
                ->extraAttributes(['title' => $lowStockProducts->implode(', ')]) // Tooltip with product names
                ->color('danger')
                ->icon('heroicon-o-exclamation-circle'),

            Stat::make('Total Active Products', Product::count()),

            Stat::make('Total Active Categories', Product::distinct('category_id')->count()),
        ];
    }
}
