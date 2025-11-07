<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\User;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'test@example.com')->first();

        $defaultIncome = [
            'Salary', 'Bonus', 'Interest'
        ];

        $defaultExpense = [
            'Food', 'Transport', 'Utilities', 'Entertainment', 'Other'
        ];

        foreach ($defaultIncome as $name) {
            Category::updateOrCreate([
                'user_id' => $user->id,
                'name' => $name,
                'type' => 'income'
            ]);
        }

        foreach ($defaultExpense as $name) {
            Category::updateOrCreate([
                'user_id' => $user->id,
                'name' => $name,
                'type' => 'expense'
            ]);
        }
    }
}
