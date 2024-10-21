<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Product;
use Filament\Actions;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewProduct extends ViewRecord
{
    protected static string $resource = ProductResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Information')
                    ->schema([
                        TextEntry::make('sku')
                            ->label('SKU'),
                        TextEntry::make('name'),
                        TextEntry::make('description'),
                    ]),
                Section::make('Stock Information')
                    ->schema([
                        Grid::make()
                            ->schema([
                                TextEntry::make('quantity'),
                                TextEntry::make('price')
                                    ->money('IDR', locale: 'id'),
                            ])
                    ]),
                Section::make('Metadata')
                    ->schema([
                        Grid::make()
                            ->schema([
                                TextEntry::make('created_at')
                                    ->state(fn (Product $product): string => "{$product->created_at->format('d F Y h:m:s')} ({$product->created_at->diffForHumans()})"),
                                TextEntry::make('updated_at')
                                    ->state(fn (Product $product): string => "{$product->updated_at->format('d F Y h:m:s')} ({$product->updated_at->diffForHumans()})"),
                            ]),
                    ]),
                Section::make('Order Histories')
                    ->schema([
                        RepeatableEntry::make('orders')
                            ->label('')
                            ->schema([
                                Grid::make()
                                    ->schema([
                                        TextEntry::make('order.order_number'),
                                        TextEntry::make('quantity'),
                                        TextEntry::make('product_price')
                                            ->money('IDR', locale: 'id'),
                                        TextEntry::make('order.status')
                                            ->label('Status')
                                            ->badge(),
                                    ])
                                    ->columns(4),
                            ]),
                    ]),
            ]);
    }
}
