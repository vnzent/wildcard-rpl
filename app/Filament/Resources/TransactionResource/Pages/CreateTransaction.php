<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use App\Models\Transaction;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;

    protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Check if 'order_id' is passed in the query string and set it
        if (request()->has('order_id')) {
            $data['order_id'] = request()->get('order_id');
        }

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
//        dd($data);
        return DB::transaction(function () use ($data) {
            $transaction = Transaction::create($data);

            $transaction->payment()->create($data['payment']);

            return $transaction;
        });
    }
}
