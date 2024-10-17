<?php

namespace App\Filament\Resources;

use App\Enums\OrderStatus;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Order Details')
                    ->schema([

                        // Customer Information (single column layout)
                        Forms\Components\Select::make('customer_id')
                            ->label('Customer')
                            ->options(\App\Models\Customer::pluck('name', 'id')) // Load customers
                            ->required()
                            ->searchable()
                            ->placeholder('Select a customer'),

                        // Products Section with Repeater for multiple products
                        Forms\Components\Repeater::make('order_products')
                            ->relationship('orderProducts') // Make sure you have this relationship in the Order model
                            ->schema([
                                // Use Columns to align Product, Quantity, and Price side by side
                                Forms\Components\Grid::make(4)
                                    ->schema([
                                        // Product Selection
                                        Forms\Components\Select::make('product_id')
                                            ->label('Product')
                                            ->options(\App\Models\Product::pluck('name', 'id')) // Load products
                                            ->required()
                                            ->searchable()
                                            ->reactive()
                                            ->afterStateUpdated(function ($state, callable $set) {
                                                // Fetch the product price when a product is selected
                                                $product = \App\Models\Product::find($state);
                                                if ($product) {
                                                    $set('product_price', $product->price);
                                                }
                                            })
                                            ->placeholder('Select a product'),

                                        // Quantity input
                                        Forms\Components\TextInput::make('quantity')
                                            ->label('Quantity')
                                            ->required()
                                            ->numeric()
                                            ->default(1) // Default value of 1
                                            ->reactive() // Reactively update total when quantity changes
                                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                                // Update total price based on quantity and product price
                                                $productPrice = $get('product_price');
                                                $set('total_price', $productPrice * $state);
                                            })
                                            ->placeholder('Enter quantity'),

                                        // Product Price (disabled, auto-populated)
                                        Forms\Components\TextInput::make('product_price')
                                            ->label('Price')
                                            ->disabled() // Price is auto-calculated and shouldn't be editable
                                            ->numeric()
                                            ->reactive(),

                                        // Total Price (based on quantity * price)
                                        Forms\Components\TextInput::make('total_price')
                                            ->label('Total')
                                            ->disabled()
                                            ->numeric()
                                            ->default(0), // Set default to 0
                                    ]),
                            ])
                            ->collapsible()
                            ->addActionLabel('Add Another Product'),
                    ]),
            ]);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->searchable()
                    ->sortable(),
                    Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->label('Status')
                    ->formatStateUsing(fn (OrderStatus $state): string => match ($state) {
                        OrderStatus::PENDING => 'Pending',
                        OrderStatus::PROCESSING => 'Processing',
                        OrderStatus::COMPLETED => 'Completed',
                        OrderStatus::CANCELLED => 'Cancelled',
                        default => 'Unknown',
                    })
                    ->color(fn (OrderStatus $state): string => match ($state) {
                        OrderStatus::PENDING => 'gray',
                        OrderStatus::PROCESSING => 'warning',
                        OrderStatus::COMPLETED => 'success',
                        OrderStatus::CANCELLED => 'danger',
                        default => 'secondary',
                    })
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
