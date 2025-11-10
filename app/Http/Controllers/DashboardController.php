<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // === 1. Hitung total income & expense ===
        $totalIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->sum('amount');

        $totalExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->sum('amount');

        // === 2. Ambil transaksi terbaru (maks. 5) ===
        $latestTransactions = Transaction::where('user_id', $userId)
            ->orderBy('transaction_date', 'desc')
            ->limit(5)
            ->get();

        // === 3. Siapkan data bulanan untuk grafik ===
        $startDate = Carbon::now()->startOfYear();
        $endDate = Carbon::now()->endOfYear();

        $months = [];
        $monthlyIncome = [];
        $monthlyExpense = [];

        for ($date = $startDate->copy(); $date <= $endDate; $date->addMonth()) {
            $months[] = $date->format('M'); // Jan, Feb, Mar...

            $income = Transaction::where('user_id', $userId)
                ->where('type', 'income')
                ->whereYear('transaction_date', $date->year)
                ->whereMonth('transaction_date', $date->month)
                ->sum('amount');

            $expense = Transaction::where('user_id', $userId)
                ->where('type', 'expense')
                ->whereYear('transaction_date', $date->year)
                ->whereMonth('transaction_date', $date->month)
                ->sum('amount');

            $monthlyIncome[] = $income;
            $monthlyExpense[] = $expense;
        }

        // === 4. Top 3 kategori pengeluaran bulan ini ===
        $currentMonth = Carbon::now()->month;
        $topCategories = Transaction::select('category', DB::raw('SUM(amount) as total'))
            ->where('user_id', $userId)
            ->where('type', 'expense')
            ->whereMonth('transaction_date', $currentMonth)
            ->groupBy('category')
            ->orderByDesc('total')
            ->limit(3)
            ->get();

        // === 5. Kirim semua data ke dashboard.blade.php ===
        return view('dashboard', compact(
            'totalIncome',
            'totalExpense',
            'latestTransactions',
            'months',
            'monthlyIncome',
            'monthlyExpense',
            'topCategories'
        ));
    }
}
