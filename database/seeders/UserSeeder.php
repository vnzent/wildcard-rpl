<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->createMany([
            ['name' => 'admin', 'email' => 'admin@example.com', 'role' => Role::ADMINISTRATOR],
            ['name' => 'Arikusuma Wardana', 'email' => 'arikusuma@arijaya.com', 'role' => Role::ADMINISTRATOR],
            ['name' => 'Nauval Khilmi', 'email' => 'nauvalkhilmi@arijaya.com', 'role' => Role::ADMINISTRATOR],
            ['name' => 'Adi Aryasuta', 'email' => 'adiaryasuta@arijaya.com', 'role' => Role::ADMINISTRATOR],
            ['name' => 'Vincent Dua Orang', 'email' => 'vincentptk@arijaya.com', 'role' => Role::ADMINISTRATOR],
            ['name' => 'Momet Dwika', 'email' => 'mometdwika@arijaya.com', 'role' => Role::ADMINISTRATOR],
        ]);

        User::factory()->count(14)->create();
    }
}
