<?php

namespace App\Filament\Resources\TransactionResource\Widgets;

use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TransactionCountWidget extends BaseWidget
{
    protected static ?int $sort = -2;

    protected static bool $isLazy = false;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Transactions', Transaction::whereDate('created_at', now())->count())
                ->description('Today')
                ->color('success'),

            // total sum of transactions
            Stat::make('Total Revenue', 'Rp' . number_format(Transaction::whereDate('created_at', now())->sum('grand_total')))
                ->description('Today')
                ->color('success'),
            
            // Stat::make('Total Transactions', Transaction::count())
            //     ->description('All time')
            //     ->color('primary'),

            // // total sum of transactions
            Stat::make('Total Revenue', 'Rp' . number_format(Transaction::sum('grand_total')))
                ->description('All time')
                ->color('primary'),
        ];
    }
}
