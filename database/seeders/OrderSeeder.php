<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all(['id']);

        Order::factory()->count(20)->has(
            OrderProduct::factory()->count(rand(3, 12))
                ->for($products->random()),
        )->create();
    }
}
