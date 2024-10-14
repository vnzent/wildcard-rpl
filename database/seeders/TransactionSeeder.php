<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = Order::all(['id']);
        $users = User::all(['id']);

        $orders->each(function (Order $order) use ($users) {
            Transaction::factory()->for($order)->for($users->random())->has(Payment::factory())->create();
        });
    }
}
