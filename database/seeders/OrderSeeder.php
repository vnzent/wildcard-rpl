<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all(['id', 'price']);

        for ($i = 0; $i < 25; $i++) {
            Order::factory()->has(OrderProduct::factory()->for($products->random())->count(rand(1, 20)))->create();
        }
    }
}
