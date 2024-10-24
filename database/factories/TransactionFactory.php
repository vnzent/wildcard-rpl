<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
//            'date' => $this->faker->date(),
            'total_amount' => rand(1_000, 1_000_000),
            'grand_total' => rand(1_000, 1_000_000),
            'cash' => rand(1_000, 1_000_000),
            'change' => rand(1_000, 1_000_000),
        ];
    }
}
