<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Enums\OrderStatus;
use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function getActions(): array
    {
        return [
            // The default Create button will already be here
            Action::make('Pay')
                ->label('Pay') // Label for the button
                ->icon('heroicon-o-banknotes') // Optional: Cash icon for the button
                ->action(function () {
                     // Get the form data
                     $data = $this->form->getState();

                     // Add the status field to the form data (set to PROCESSING)
                     $data['status'] = OrderStatus::PROCESSING;
 
                     // Save the record with the new status
                     $this->create();

                    // Redirect to the transaction creation page with the saved order ID
                    return redirect()->route('filament.admin.resources.transactions.create', [
                        'order_id' => $this->record->id, // Pass the newly created order ID to the transaction page
                    ]);
                })
                ->requiresConfirmation() // Optional: ask for confirmation before processing
                ->color('success') // Optional: green color for the "Pay" button
        ];
    }
}
