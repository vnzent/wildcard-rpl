<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 categories
        $categories = [
            'Makanan Ringan',
            'Minuman',
            'Bumbu Dapur',
            'Sembako',
            'Alat Tulis',
            'Perlengkapan Kebersihan',
            'Perlengkapan Rumah Tangga',
        ];

        foreach ($categories as $category) {
            \App\Models\Category::factory()->create([
                'name' => $category,
            ]);
        }
    }
}
