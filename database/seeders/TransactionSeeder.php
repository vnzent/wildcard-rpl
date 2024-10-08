<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::all(['id'])->each(function (Order $order) {
            Transaction::factory()->for($order)->has(Payment::factory())->create();
        });
    }
}
