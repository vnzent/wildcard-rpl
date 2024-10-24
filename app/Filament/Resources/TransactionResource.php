<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Order;
use App\Models\Transaction;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Query\Builder;
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
                        // Cashier Information
                        TextInput::make('cashier_name')
                            ->label('Cashier')
                            ->default(auth()->user()->name)
                            ->disabled()
                            ->required(),

                        Hidden::make('cashier_id')
                            ->default(auth()->id())
                            ->required(),

                        // Order-related helper functions
                        TextInput::make('order_number')
                            ->label('Order Number')
                            ->default(fn($record) => static::getOrderNumber($record))
                            ->disabled()
                            ->required(),

                        Hidden::make('order_id')
                            ->default(fn($record) => static::getOrderId($record))
                            ->required(),

                        // Hidden Total Amount for saving to the database
                        Hidden::make('total_amount')
                            ->default(fn($record) => static::calculateTotalAmount($record))
                            ->required(),

                        // Grand Total Field
                        TextInput::make('grand_total_display')
                            ->numeric()
                            ->required()
                            ->disabled()
                            ->label('Grand Total')
                            ->reactive()
                            ->default(fn($get) => max(0, $get('total_amount'))),

                        Hidden::make('grand_total')
                            ->default(fn($get) => $get('grand_total_display'))
                            ->required(),

                        // Cash Field
                        TextInput::make('cash')
                            ->numeric()
                            ->required()
                            ->label('Cash')
                            ->reactive()
                            ->debounce(600)
                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                $grandTotal = $get('grand_total');
                                $change = $state - $grandTotal;
                                $set('change_display', $change);
                                $set('change', $change);
                            }),

                        // Change Field
                        TextInput::make('change_display')
                            ->numeric()
                            ->required()
                            ->disabled()
                            ->label('Change')
                            ->reactive(),

                        Hidden::make('change')
                            ->default(fn($get) => $get('change_display'))
                            ->reactive()
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order.order_number')
                    ->label('Order Number')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('grand_total')
                    ->label('Grand Total')
                    ->money('IDR', locale: 'id')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('cashier.name')
                    ->label('Cashier')
                    ->searchable()
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
                            ->fromForm()
//                            ->modifyQueryUsing(fn (array $data, Builder $query) => $query->whereBetween('created_at', [$data['start_date'], $data['end_date']]))
                            ->askForFilename()
                            ->askForWriterType(default: \Maatwebsite\Excel\Excel::XLSX)
                            ->withFilename(fn (string $filename): string => date('Ymd-His') . '-' . $filename),
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
