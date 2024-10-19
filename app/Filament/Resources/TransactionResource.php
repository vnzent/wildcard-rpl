<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Order;
use App\Models\Transaction;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\View;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

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

                        // Order-related helper functions
                        TextInput::make('order_number')
                            ->label('Order Number')
                            ->default(fn($record) => static::getOrderNumber($record))
                            ->disabled()
                            ->required(),

                        Hidden::make('order_id')
                            ->default(fn($record) => static::getOrderId($record))
                            ->required(),

                        // Total Amount Displayed to the User (Disabled, calculated)
                        TextInput::make('total_amount_display')
                            ->label('Total Amount')
                            ->default(fn($record) => static::calculateTotalAmount($record))
                            ->disabled()
                            ->reactive()
                            ->required(),

                        // Hidden Total Amount for saving to the database
                        Hidden::make('total_amount')
                            ->default(fn($record) => static::calculateTotalAmount($record))
                            ->required(),

                        // Discount Field
                        TextInput::make('discount')
                            ->numeric()
                            ->label('Discount')
                            ->reactive()
                            ->afterStateUpdated(
                                fn(callable $set, $state, $get) =>
                                $set('grand_total', max(0, $get('total_amount') - $state))
                            ),

                        // Grand Total Field
                        TextInput::make('grand_total')
                            ->numeric()
                            ->required()
                            ->label('Grand Total')
                            ->reactive()
                            ->default(fn($get) => max(0, $get('total_amount') - $get('discount'))),

                        // Cashier Information
                        TextInput::make('cashier_name')
                            ->label('Cashier')
                            ->default(auth()->user()->name)
                            ->disabled()
                            ->required(),

                        Hidden::make('cashier_id')
                            ->default(auth()->id())
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

                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total Amount')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('discount')
                    ->label('Discount')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('grand_total')
                    ->label('Grand Total')
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
            ->actions([])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
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
}
