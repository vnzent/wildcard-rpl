<?php

namespace App\Filament\Resources;

use App\Enums\PaymentType;
use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Order;
use App\Models\Transaction;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Number;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Services';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Transaction Details')
                    ->schema([
                        TextInput::make('Cashier Name')
                            ->default(auth()->user()->name)
                            ->disabled()
                            ->required(),
                        Hidden::make('cashier_id')
                            ->default(auth()->id())
                            ->required(),
                        Hidden::make('order_id')
                            ->default(fn($record) => static::getOrderId($record))
                            ->required(),
                        MoneyInput::make('grand_total_display')
                            ->label('Grand Total')
                            ->required()
                            ->disabled()
                            ->reactive()
                            ->default(fn($record) => static::calculateTotalAmount($record) * 100),
                        Hidden::make('grand_total')
                            ->default(fn($get) => intval(str_replace('.', '', $get('grand_total_display'))))
                            ->required(),
                    ]),
                Section::make('Payment')
                    ->schema([
                        Select::make('payment.type')
                            ->options(PaymentType::class)
                            ->required(),
                        MoneyInput::make('payment.amount')
                            ->autofocus()
                            ->required()
                            ->reactive()
                            ->debounce()
                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                $grandTotal = intval(str_replace('.', '', $get('grand_total_display')));

                                $change =  $state - $grandTotal;

                                $set('payment.change', $change);
                            }),
                        MoneyInput::make('payment.change')
                            ->default(0)
                            ->reactive()
                            ->required()
                            ->readOnly(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('grand_total')
                    ->money('IDR', locale: 'id')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cashier.name')
                    ->label('Cashier')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                ExportAction::make('export')
                    ->exports([
                        ExcelExport::make('transactions')
                            ->fromTable()
//                            ->modifyQueryUsing(fn (array $data, Builder $query) => $query->whereBetween('created_at', [$data['start_date'], $data['end_date']]))
                            ->askForFilename()
                            ->askForWriterType(default: \Maatwebsite\Excel\Excel::XLSX)
                            ->withFilename(fn(string $filename): string => date('Ymd-His') . '-' . $filename),
                    ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    ExportBulkAction::make()->modal(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'view' => Pages\ViewTransaction::route('/{record}'),
        ];
    }

    public static function getOrderId($record)
    {
        return $record ? $record->order_id : request()->get('order_id');
    }

    public static function getOrderNumber($record)
    {
        $orderId = static::getOrderId($record);
        return $orderId ? Order::find($orderId)?->order_number : null;
    }

    public static function calculateTotalAmount($record)
    {
        $orderId = static::getOrderId($record);
        if (!$orderId) {
            return 0;
        }

        $order = Order::find($orderId);
        return $order ? $order->orderProducts->sum(fn($orderProduct) => $orderProduct->product_price * $orderProduct->quantity) : 0;
    }
}
