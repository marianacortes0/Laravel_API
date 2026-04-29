<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::insert([
            ['name' => 'Alice',   'email' => 'alice@example.com',   'age' => 30, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bob',     'email' => 'bob@example.com',     'age' => 25, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Charlie', 'email' => 'charlie@example.com', 'age' => 35, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
