<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center p-5 rounded-2xl shadow-lg 
                    bg-gradient-to-r from-emerald-100 via-teal-50 to-blue-100 backdrop-blur-md border border-white/40">
            <h2 class="font-bold text-2xl bg-gradient-to-r from-emerald-600 to-blue-600 
                       bg-clip-text text-transparent tracking-wide drop-shadow-md">
                💰 Transactions
            </h2>

            <!-- 🌟 Add Transaction Button -->
            <a href="{{ route('transactions.create') }}" 
   class="inline-flex items-center gap-2 bg-gradient-to-r from-green-500 via-emerald-500 to-teal-600
          text-white font-semibold px-6 py-3 rounded-xl shadow-lg border border-white/20
          hover:shadow-[0_0_25px_rgba(16,185,129,0.5)] hover:scale-105 transition-all duration-300 tracking-wide
          [text-shadow:_0_1px_3px_rgba(0,0,0,0.3)]">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 drop-shadow-md" 
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M12 4v16m8-8H4" />
                </svg>
                <span class="drop-shadow-md">Add Transaction</span>
            </a>
        </div>
    </x-slot>

    <!-- 🌈 Background Section -->
    <div class="py-12 relative min-h-screen bg-gradient-to-br from-emerald-100 via-white to-blue-100 overflow-hidden">
        <!-- Soft background orbs -->
        <div class="absolute top-0 left-0 w-96 h-96 bg-emerald-400/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 right-0 w-[28rem] h-[28rem] bg-blue-400/20 rounded-full blur-3xl animate-pulse"></div>

        <div class="relative max-w-7xl mx-auto sm:px-6 lg:px-8 z-10">
            <!-- ✅ Card Container -->
            <div class="bg-white/70 backdrop-blur-2xl shadow-2xl rounded-3xl p-8 border border-white/30 
                        hover:shadow-emerald-200/50 transition-all duration-500">

                <!-- ✅ Filter Section -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-3">
                    <form action="{{ route('transactions.index') }}" method="GET" 
                          class="flex flex-wrap gap-3 items-center">

                        <select name="type" 
                                class="border-gray-300 rounded-xl px-4 py-2 text-sm shadow focus:ring-emerald-200 focus:border-emerald-400 transition">
                            <option value="">All Types</option>
                            <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Income</option>
                            <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Expense</option>
                        </select>

                        <select name="category" 
                                class="border-gray-300 rounded-xl px-4 py-2 text-sm shadow focus:ring-blue-200 focus:border-blue-400 transition">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->name }}" {{ request('category') == $category->name ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        <button type="submit" 
                            class="bg-gradient-to-r from-gray-700 to-gray-900 hover:from-gray-800 hover:to-black text-white px-5 py-2 rounded-xl shadow-md hover:shadow-lg transition font-semibold">
                            Filter
                        </button>
                    </form>
                </div>

                <!-- ✅ Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                    <div class="bg-gradient-to-br from-green-50 to-white p-6 rounded-2xl shadow group hover:shadow-xl transition">
                        <p class="text-green-700 font-semibold mb-1">Total Income</p>
                        <p class="text-3xl font-extrabold text-green-600">
                            Rp {{ number_format($totalIncome, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="bg-gradient-to-br from-red-50 to-white p-6 rounded-2xl shadow group hover:shadow-xl transition">
                        <p class="text-red-700 font-semibold mb-1">Total Expense</p>
                        <p class="text-3xl font-extrabold text-red-600">
                            Rp {{ number_format($totalExpense, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="bg-gradient-to-br from-blue-50 to-white p-6 rounded-2xl shadow group hover:shadow-xl transition">
                        <p class="text-blue-700 font-semibold mb-1">Balance</p>
                        <p class="text-3xl font-extrabold text-blue-600">
                            Rp {{ number_format($totalIncome - $totalExpense, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <!-- ✅ Chart -->
                <div class="mb-10">
                    <div id="transactionChart"></div>
                </div>

                <!-- ✅ Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 rounded-2xl overflow-hidden shadow">
                        <thead class="bg-gray-100 text-gray-600 text-xs uppercase font-bold tracking-wide">
                            <tr>
                                <th class="px-6 py-3 text-left">Date</th>
                                <th class="px-6 py-3 text-left">Description</th>
                                <th class="px-6 py-3 text-left">Category</th>
                                <th class="px-6 py-3 text-left">Type</th>
                                <th class="px-6 py-3 text-left">Amount</th>
                                <th class="px-6 py-3 text-left">Receipt</th>
                                <th class="px-6 py-3 text-left">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($transactions as $transaction)
                            <tr class="hover:bg-gray-50 transition">
                               <td class="px-6 py-4 text-sm">
    {{ $transaction->transaction_date ? $transaction->transaction_date->format('d/m/Y') : '-' }}
</td>

                                <td class="px-6 py-4 text-sm">{{ $transaction->description }}</td>
                                <td class="px-6 py-4 text-sm">{{ $transaction->category }}</td>

                                <td class="px-6 py-4 text-sm">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold
                                        {{ $transaction->type === 'income' 
                                            ? 'bg-green-100 text-green-700' 
                                            : 'bg-red-100 text-red-700' }}">
                                        {{ ucfirst($transaction->type) }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-sm font-semibold
                                    {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                    Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                </td>

                                <td class="px-6 py-4 text-sm">
                                    @if($transaction->receipt_image)
                                        <a href="{{ asset('storage/' . $transaction->receipt_image) }}" 
                                           class="text-blue-600 hover:text-blue-800 hover:underline font-medium" 
                                           target="_blank">View</a>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 flex gap-3 text-sm">
                                    <a href="{{ route('transactions.edit', $transaction) }}" 
                                       class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>

                                    <form action="{{ route('transactions.destroy', $transaction) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            class="text-red-600 hover:text-red-800 font-medium delete-transaction">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="py-6 text-center text-gray-500">
                                    No transactions found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@push('scripts')
<script>
document.querySelectorAll('.delete-transaction').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        let form = this.closest("form");
        Swal.fire({
            title: 'Delete Transaction?',
            text: "This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Delete'
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });
});

var options = {
    series: [
        { name: 'Income', data: @json($monthlyIncome) },
        { name: 'Expense', data: @json($monthlyExpense) }
    ],
    chart: { type: 'bar', height: 350 },
    plotOptions: { bar: { columnWidth: '55%', borderRadius: 6 }},
    dataLabels: { enabled: false },
    xaxis: { categories: @json($months) },
    colors: ['#10B981', '#EF4444']
};

new ApexCharts(document.querySelector("#transactionChart"), options).render();
</script>
@endpush
