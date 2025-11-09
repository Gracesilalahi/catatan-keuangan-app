<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Transaction::where('user_id', auth()->id());

        // Apply filters if any
        if ($request->type) {
            $query->where('type', $request->type);
        }
        if ($request->category) {
            $query->where('category', $request->category);
        }
        if ($request->search) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        // PERBAIKAN 1: Mengubah latest('date')
        $transactions = $query->latest('transaction_date')->paginate(10)->withQueryString();

        // Calculate totals
        $totalIncome = Transaction::where('user_id', auth()->id())
            ->where('type', 'income')
            ->sum('amount');

        $totalExpense = Transaction::where('user_id', auth()->id())
            ->where('type', 'expense')
            ->sum('amount');

        // Prepare data for chart
        $startDate = Carbon::now()->startOfYear();
        $endDate = Carbon::now()->endOfYear();
        $monthlyIncome = [];
        $monthlyExpense = [];
        $months = [];

        for ($date = $startDate->copy(); $date <= $endDate; $date->addMonth()) {
            $month = $date->format('M Y');
            $months[] = $month;

            // PERBAIKAN 2: Mengubah whereYear/Month('date', ...)
            $monthlyIncome[] = Transaction::where('user_id', auth()->id())
                ->where('type', 'income')
                ->whereYear('transaction_date', $date->year)
                ->whereMonth('transaction_date', $date->month)
                ->sum('amount');

            // PERBAIKAN 3: Mengubah whereYear/Month('date', ...)
            $monthlyExpense[] = Transaction::where('user_id', auth()->id())
                ->where('type', 'expense')
                ->whereYear('transaction_date', $date->year)
                ->whereMonth('transaction_date', $date->month)
                ->sum('amount');
        }

        // get categories for select
        $categories = \App\Models\Category::where(function($q){
            $q->whereNull('user_id')->orWhere('user_id', auth()->id());
        })->orderBy('type')->orderBy('name')->get();

        return view('transactions.index', compact(
            'transactions',
            'totalIncome',
            'totalExpense',
            'months',
            'monthlyIncome',
            'monthlyExpense',
            'categories'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = \App\Models\Category::where(function($q){
            $q->whereNull('user_id')->orWhere('user_id', auth()->id());
        })->orderBy('type')->orderBy('name')->get();

        return view('transactions.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:255',
            // PERBAIKAN 4: Mengubah validasi 'date'
            'transaction_date' => 'required|date',
            'receipt_image' => 'nullable|image|max:2048' // max 2MB
        ]);

        if ($request->hasFile('receipt_image')) {
            $path = $request->file('receipt_image')->store('receipts', 'public');
            $validated['receipt_image'] = $path;
        }

        // PERBAIKAN 5: Memastikan data yang disimpan menggunakan nama kolom yang benar
        $validated['user_id'] = auth()->id();
        $validated['date'] = $validated['transaction_date']; // Tambahkan jika form Anda masih mengirimkan 'date'

        $transaction = Transaction::create($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        // Authorize that the current user owns this transaction
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        $categories = \App\Models\Category::where(function($q){
            $q->whereNull('user_id')->orWhere('user_id', auth()->id());
        })->orderBy('type')->orderBy('name')->get();

        return view('transactions.edit', compact('transaction', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        // Authorize that the current user owns this transaction
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:255',
            // PERBAIKAN 6: Mengubah validasi 'date'
            'transaction_date' => 'required|date',
            'receipt_image' => 'nullable|image|max:2048' // max 2MB
        ]);

        if ($request->hasFile('receipt_image')) {
            // Delete old image if exists
            if ($transaction->receipt_image) {
                Storage::disk('public')->delete($transaction->receipt_image);
            }
            // Store new image
            $path = $request->file('receipt_image')->store('receipts', 'public');
            $validated['receipt_image'] = $path;
        }

        // PERBAIKAN 7: Memastikan data yang diupdate menggunakan nama kolom yang benar
        $validated['date'] = $validated['transaction_date'];

        $transaction->update($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        // Authorize that the current user owns this transaction
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        // Delete receipt image if exists
        if ($transaction->receipt_image) {
            Storage::disk('public')->delete($transaction->receipt_image);
        }

        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction deleted successfully.');
    }

    /**
     * Export filtered transactions as CSV
     */
    public function export(Request $request)
    {
        $query = Transaction::where('user_id', auth()->id());

        if ($request->type) {
            $query->where('type', $request->type);
        }
        if ($request->category) {
            $query->where('category', $request->category);
        }
        if ($request->search) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        // PERBAIKAN 8: Mengubah latest('date')
        $transactions = $query->latest('transaction_date')->get();

        $filename = 'transactions_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        // PERBAIKAN 9: Mengubah nama kolom CSV
        $columns = ['Transaction Date', 'Description', 'Category', 'Type', 'Amount'];

        $callback = function() use ($transactions, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($transactions as $t) {
                fputcsv($file, [
                    // PERBAIKAN 10: Mengubah $t->date->toDateString()
                    $t->transaction_date->toDateString(),
                    $t->description,
                    $t->category,
                    $t->type,
                    number_format($t->amount, 2, '.', ''),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}