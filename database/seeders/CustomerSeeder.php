<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create([
            'name' => 'Guest',
            'email' => 'guest@example.test',
            'phone' => '081234567890',
            'birth_date' => '2000-01-01',
        ]);
    }
}
