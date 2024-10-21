<?php

namespace App\Filament\Resources\TransactionResource\Widgets;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;

class TransactionChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Transaction Chart';

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $transactions = Transaction::selectRaw('MONTH(created_at) as month, SUM(grand_total) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Fill missing months with 0 transactions
        $transactionData = array_replace(array_fill(1, 12, 0), $transactions);

        return [
            'datasets' => [
                [
                    'label' => 'Total Transactions',
                    'data' => array_values($transactionData), // Data for the chart
                ],
            ],
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'], // Labels for the X-axis
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
