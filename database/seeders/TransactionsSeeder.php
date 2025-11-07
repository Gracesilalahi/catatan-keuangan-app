<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;

class TransactionsSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'test@example.com')->first();
        if (! $user) return;

        $today = Carbon::now();

        $samples = [
            ['description' => 'Salary for October', 'amount' => 5000000, 'type' => 'income', 'category' => 'Salary', 'date' => $today->copy()->subDays(10)],
            ['description' => 'Groceries', 'amount' => 250000, 'type' => 'expense', 'category' => 'Food', 'date' => $today->copy()->subDays(8)],
            ['description' => 'Transport to office', 'amount' => 50000, 'type' => 'expense', 'category' => 'Transport', 'date' => $today->copy()->subDays(6)],
            ['description' => 'Movie night', 'amount' => 120000, 'type' => 'expense', 'category' => 'Entertainment', 'date' => $today->copy()->subDays(4)],
            ['description' => 'Freelance income', 'amount' => 800000, 'type' => 'income', 'category' => 'Bonus', 'date' => $today->copy()->subDays(2)],
        ];

        foreach ($samples as $s) {
            Transaction::create([
                'user_id' => $user->id,
                'description' => $s['description'],
                'amount' => $s['amount'],
                'type' => $s['type'],
                'category' => $s['category'],
                'date' => $s['date']->toDateString(),
            ]);
        }
    }
}
