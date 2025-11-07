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
        // Seed a test user and example data for local development
        $this->call([
            UserSeeder::class,
            \Database\Seeders\CategoriesSeeder::class,
            \Database\Seeders\TransactionsSeeder::class,
        ]);
    }
}
