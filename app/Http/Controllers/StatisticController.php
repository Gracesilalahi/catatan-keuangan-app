<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class StatisticController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil semua transaksi user
        $transactions = Transaction::where('user_id', $user->id)->get();

        // Total pemasukan dan pengeluaran
        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');

        // Saldo bersih
        $balance = $totalIncome - $totalExpense;

        // Statistik bulanan (PostgreSQL version)
        $monthlyStats = DB::table('transactions')
            ->selectRaw("
                EXTRACT(MONTH FROM transaction_date)::int AS month,
                SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) AS total_income,
                SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) AS total_expense
            ")
            ->where('user_id', $user->id)
            ->groupByRaw('EXTRACT(MONTH FROM transaction_date)')
            ->orderByRaw('EXTRACT(MONTH FROM transaction_date)')
            ->get();

        // Kirim data ke view
        return view('statistics.index', compact('totalIncome', 'totalExpense', 'balance', 'monthlyStats'));
    }
}
