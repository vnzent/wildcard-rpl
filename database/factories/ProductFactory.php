<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sku' => $this->faker->unique()->ean8(),
            'name' => 'product - '.$this->faker->words(3, true),
            'description' => $this->faker->text(),
            'price' => $this->faker->numberBetween(10000, 1000000),
            'quantity' => $this->faker->numberBetween(10, 400),
        ];
    }
}
