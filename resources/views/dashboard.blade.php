<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-slate-800 tracking-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-gradient-to-br from-slate-50 via-white to-emerald-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-10">

            <!-- === Summary Cards === -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="rounded-2xl p-6 bg-gradient-to-br from-emerald-100 to-emerald-200 shadow-lg hover:shadow-2xl transition">
                    <h3 class="font-semibold text-lg text-emerald-900 mb-2">Total Income</h3>
                    <p class="text-4xl font-bold text-emerald-700">
                        Rp {{ number_format($totalIncome, 0, ',', '.') }}
                    </p>
                </div>

                <div class="rounded-2xl p-6 bg-gradient-to-br from-rose-100 to-rose-200 shadow-lg hover:shadow-2xl transition">
                    <h3 class="font-semibold text-lg text-rose-900 mb-2">Total Expense</h3>
                    <p class="text-4xl font-bold text-rose-700">
                        Rp {{ number_format($totalExpense, 0, ',', '.') }}
                    </p>
                </div>

                <div class="rounded-2xl p-6 bg-gradient-to-br from-indigo-100 to-indigo-200 shadow-lg hover:shadow-2xl transition">
                    <h3 class="font-semibold text-lg text-indigo-900 mb-2">Balance</h3>
                    <p class="text-4xl font-bold text-indigo-700">
                        Rp {{ number_format($totalIncome - $totalExpense, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <!-- === Main Section === -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <!-- Latest Transactions -->
                <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition p-6">
                    <div class="flex justify-between items-center mb-4 border-b pb-2">
                        <h3 class="font-semibold text-2xl text-slate-800">Latest Transactions</h3>
                        <a href="{{ route('transactions.index') }}"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-400 transition">
                            View All
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-gray-700">
                            <thead class="bg-slate-100 text-gray-600 uppercase text-xs">
                                <tr>
                                    <th class="text-left py-2 px-3 font-semibold">Date</th>
                                    <th class="text-left py-2 px-3 font-semibold">Description</th>
                                    <th class="text-left py-2 px-3 font-semibold">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($latestTransactions as $transaction)
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="py-2 px-3">{{ $transaction->date->format('d/m/Y') }}</td>
                                        <td class="py-2 px-3">{{ $transaction->description }}</td>
                                        <td class="py-2 px-3 font-semibold {{ $transaction->type === 'income' ? 'text-emerald-600' : 'text-rose-600' }}">
                                            {{ $transaction->type === 'income' ? '+' : '-' }}
                                            Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="py-4 text-center text-gray-400 italic">
                                            No transactions found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Button to Add New Transaction -->
                    <div class="mt-6 text-right">
                        <a href="{{ route('transactions.create') }}"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:ring-2 focus:ring-emerald-400 transition">
                            + Add Transaction
                        </a>
                    </div>
                </div>

                <!-- Monthly Chart -->
                <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold text-2xl text-slate-800">Monthly Overview</h3>
                        <a href="{{ route('categories.index') }}"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-indigo-700 border border-indigo-300 rounded-lg hover:bg-indigo-50 transition">
                            Manage Categories
                        </a>
                    </div>
                    <div id="monthlyChart" class="w-full h-80"></div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    var options = {
        series: [
            { name: 'Income', data: @json($monthlyIncome) },
            { name: 'Expense', data: @json($monthlyExpense) }
        ],
        chart: {
            type: 'area',
            height: 350,
            toolbar: { show: false },
        },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 3 },
        xaxis: {
            categories: @json($months),
            labels: { style: { colors: '#475569' } },
        },
        yaxis: {
            labels: {
                style: { colors: '#475569' },
                formatter: val => 'Rp ' + val.toLocaleString('id-ID')
            }
        },
        tooltip: {
            theme: 'light',
            y: { formatter: val => 'Rp ' + val.toLocaleString('id-ID') }
        },
        colors: ['#10B981', '#EF4444'],
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.6,
                opacityTo: 0.1,
            }
        },
        legend: {
            position: 'top',
            horizontalAlign: 'right',
            labels: { colors: '#1e293b' },
        }
    };

    var chart = new ApexCharts(document.querySelector("#monthlyChart"), options);
    chart.render();
});
</script>
@endpush
