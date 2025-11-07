<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Financial Tracker') }}</title>

    <!-- 🌸 Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- 🌈 Tailwind & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- 🌟 Custom Pastel Glass Style -->
    <link rel="stylesheet" href="{{ asset('css/custom-style.css') }}">

    <!-- ⚡ SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- 📊 ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- 🌼 Soft Gradient Base Theme -->
    <style>
        :root {
            --primary-50: 236 253 245;
            --primary-100: 209 250 229;
            --primary-200: 167 243 208;
            --primary-300: 110 231 183;
            --primary-400: 52 211 153;
            --primary-500: 16 185 129;
            --primary-600: 5 150 105;
            --primary-700: 4 120 87;
            --primary-800: 6 95 70;
            --primary-900: 6 78 59;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f8fbff, #eafaf3, #eef6ff);
            color: #1a1a1a;
        }
    </style>
</head>

<body class="font-sans antialiased relative min-h-screen overflow-x-hidden">

    <!-- 🌤️ Soft Animated Background Pattern -->
    <div class="fixed inset-0 -z-10 opacity-40 pointer-events-none">
        <div class="absolute top-0 left-0 w-[30rem] h-[30rem] bg-emerald-300/30 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 right-0 w-[35rem] h-[35rem] bg-blue-300/30 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute inset-0"
            style="background-image: url('data:image/svg+xml,%3Csvg width=\'28\' height=\'28\' viewBox=\'0 0 28 28\' fill=\'none\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M1.2 0C1.86 0 2.4 0.54 2.4 1.2C2.4 1.86 1.86 2.4 1.2 2.4C0.54 2.4 0 1.86 0 1.2C0 0.54 0.54 0 1.2 0Z\' fill=\'rgba(0,0,0,0.05)\'/%3E%3C/svg%3E'); background-repeat: repeat;">
        </div>
    </div>

    <!-- 🌈 Page Wrapper -->
    <div class="relative z-10 flex flex-col min-h-screen">
        <!-- 🧭 Navbar -->
        <header class="relative z-50">
            @include('layouts.navigation')
        </header>

        <!-- 🪞 Page Header -->
        @isset($header)
            <header class="bg-white/70 backdrop-blur-md border-b border-gray-200 shadow-md relative z-20">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- 🧾 Page Content -->
        <main class="flex-grow relative z-20">
            {{ $slot }}
        </main>

        <!-- ✨ Footer (optional aesthetic) -->
        <footer class="text-center py-6 text-gray-500 text-sm backdrop-blur-sm bg-white/40 border-t border-gray-200/50">
            <p>🌿 Financial Tracker © {{ date('Y') }} | Crafted with ❤️ by Sayang</p>
        </footer>
    </div>

    <!-- 💬 SweetAlert Blade -->
    <x-sweet-alert />

    <!-- 🧠 Page-Specific Scripts -->
    @stack('scripts')
</body>
</html>
