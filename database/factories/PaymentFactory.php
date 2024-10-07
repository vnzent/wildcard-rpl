<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Type\PaymentType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => $this->faker->randomFloat(2, 10, 100),
            'type' => PaymentType::cases()[rand(0, sizeof(PaymentType::cases()) - 1)],
        ];
    }
}
