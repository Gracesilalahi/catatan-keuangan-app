<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalIncome = Transaction::where('user_id', auth()->id())
            ->where('type', 'income')
            ->sum('amount');

        $totalExpense = Transaction::where('user_id', auth()->id())
            ->where('type', 'expense')
            ->sum('amount');

        // PERBAIKAN 1: Mengubah latest('date') menjadi latest('transaction_date')
        $latestTransactions = Transaction::where('user_id', auth()->id())
            ->latest('transaction_date') 
            ->limit(5)
            ->get();

        // Prepare data for chart
        $startDate = Carbon::now()->startOfYear();
        $endDate = Carbon::now()->endOfYear();
        $monthlyIncome = [];
        $monthlyExpense = [];
        $months = [];

        for ($date = $startDate->copy(); $date <= $endDate; $date->addMonth()) {
            $month = $date->format('M Y');
            $months[] = $month;

            // PERBAIKAN 2: Mengubah whereYear/Month('date', ...) menjadi whereYear/Month('transaction_date', ...)
            $monthlyIncome[] = Transaction::where('user_id', auth()->id())
                ->where('type', 'income')
                ->whereYear('transaction_date', $date->year)
                ->whereMonth('transaction_date', $date->month)
                ->sum('amount');

            $monthlyExpense[] = Transaction::where('user_id', auth()->id())
                ->where('type', 'expense')
                ->whereYear('transaction_date', $date->year)
                ->whereMonth('transaction_date', $date->month)
                ->sum('amount');
        }

        return view('dashboard', compact(
            'totalIncome',
            'totalExpense',
            'latestTransactions',
            'months',
            'monthlyIncome',
            'monthlyExpense'
        ));
    }
}