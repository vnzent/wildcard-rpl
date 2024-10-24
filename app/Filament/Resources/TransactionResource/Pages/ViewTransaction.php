<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ViewTransaction extends ViewRecord
{
    protected static string $resource = TransactionResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Order Information')
                    ->schema([
                        TextEntry::make('order.code'),
                    ]),
                Section::make('Transaction Information')
                    ->schema([
                        TextEntry::make('code'),
                        TextEntry::make('grand_total')
                            ->money(currency: 'IDR', locale: 'id_ID'),
                        TextEntry::make('cashier.name')
                    ]),
                Section::make('Payment Information')
                    ->schema([
                        TextEntry::make('payment.type'),
                        TextEntry::make('payment.amount')
                            ->money(currency: 'IDR', locale: 'id_ID'),
                        TextEntry::make('payment.change')
                            ->money(currency: 'IDR', locale: 'id_ID'),
                    ]),
            ]);
    }

    protected function getActions(): array
    {
        return [
            ExportAction::make('export')
                ->action(function (array $data) {
                    return ExcelExport::make('transactions')
                        ->withWriterType(match ($data['type']) {
                            'XLS' => \Maatwebsite\Excel\Excel::XLS,
                            'XLSX' => \Maatwebsite\Excel\Excel::XLSX,
                            'CSV' => \Maatwebsite\Excel\Excel::CSV,
                        })
                        ->withFilename(date('Ymd-His') . '-' . $data['filename']);
                })
                ->form([
                    TextInput::make('filename')
                        ->required(),
                    Select::make('type')
                        ->options([
                            'XLS' => \Maatwebsite\Excel\Excel::XLS,
                            'XLSX' => \Maatwebsite\Excel\Excel::XLSX,
                            'CSV' => \Maatwebsite\Excel\Excel::CSV,
                        ])
                        ->default('XLSX'),
                ]),
        ];
    }
}
