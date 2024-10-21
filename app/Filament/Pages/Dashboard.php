<?php

namespace App\Filament\Pages;

use App\Filament\Resources\ProductResource\Widgets\LowStockAlertWidget;
use App\Filament\Resources\TransactionResource\Widgets\TransactionChartWidget;
use App\Filament\Resources\TransactionResource\Widgets\TransactionCountWidget;
use Filament\Pages\Page;
use Filament\Tables\Columns\Layout\Grid;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.dashboard';

    protected int | string | array $columnSpan = 'full';

    /**
     * Return the widgets to display in the header.
     */
    public function getHeaderWidgets(): array
    {
        return [
            TransactionCountWidget::class,
            LowStockAlertWidget::class,
            TransactionChartWidget::class,
        ];
    }
}
