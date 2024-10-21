<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Enums\OrderStatus;
use App\Filament\Resources\OrderResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Default Delete action
            DeleteAction::make(),

            // Add the "Pay" button to the header
            Action::make('Pay')
                ->label('Pay') // Label for the button
                ->icon('heroicon-o-banknotes') // Optional: Cash icon for the button
                ->action(function () {
                    $this->record->status = OrderStatus::PROCESSING; // Use the enum directly

                    $this->save(); // Use save() to update the record

                    // Redirect to the transaction creation page with the saved order ID
                    return redirect()->route('filament.admin.resources.transactions.create', [
                        'order_id' => $this->record->id, // Pass the updated order ID to the transaction page
                    ]);
                })
                ->requiresConfirmation() // Optional: ask for confirmation before processing
                ->color('success'), // Optional: green color for the "Pay" button
        ];
    }
}
