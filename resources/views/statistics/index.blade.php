<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📊 Statistik Keuangan
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Ringkasan -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-green-100 p-6 rounded-xl shadow text-center">
                    <h3 class="text-lg font-semibold text-green-700">Total Pemasukan</h3>
                    <p class="text-2xl font-bold text-green-600">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
                </div>
                <div class="bg-red-100 p-6 rounded-xl shadow text-center">
                    <h3 class="text-lg font-semibold text-red-700">Total Pengeluaran</h3>
                    <p class="text-2xl font-bold text-red-600">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
                </div>
                <div class="bg-blue-100 p-6 rounded-xl shadow text-center">
                    <h3 class="text-lg font-semibold text-blue-700">Saldo Bersih</h3>
                    <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($balance, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Grafik Statistik -->
            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-lg font-semibold mb-4">Tren Keuangan Bulanan</h3>
                <div id="chart"></div>
            </div>

        </div>
    </div>

    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const monthlyData = @json($monthlyStats);

            const months = monthlyData.map(item => {
                return new Date(0, item.month - 1).toLocaleString('id-ID', { month: 'short' });
            });

            const income = monthlyData.map(item => item.total_income);
            const expense = monthlyData.map(item => item.total_expense);

            const options = {
                chart: {
                    type: 'area',
                    height: 350,
                    toolbar: { show: false },
                },
                series: [
                    { name: 'Pemasukan', data: income },
                    { name: 'Pengeluaran', data: expense },
                ],
                xaxis: {
                    categories: months,
                    title: { text: 'Bulan' }
                },
                yaxis: {
                    title: { text: 'Jumlah (Rp)' }
                },
                colors: ['#22c55e', '#ef4444'],
                fill: {
                    type: 'gradient',
                    gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.1 }
                },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth' },
                legend: { position: 'top' }
            };

            const chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();
        });
    </script>
</x-app-layout>
