<nav 
    x-data="{ open: false }" 
    class="backdrop-blur-md bg-white/80 border-b border-gray-200 shadow-sm sticky top-0 z-50 transition-all duration-300"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left Section -->
            <div class="flex items-center space-x-8">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                    <x-application-logo class="block h-10 w-auto text-emerald-600" />
                    <span class="text-xl font-extrabold bg-gradient-to-r from-emerald-600 to-blue-600 bg-clip-text text-transparent">
                        Financial Tracker
                    </span>
                </a>

                <!-- Navigation Links -->
                <div class="hidden sm:flex space-x-6">
                    <x-nav-link 
                        href="{{ route('dashboard') }}" 
                        :active="request()->routeIs('dashboard')" 
                        class="flex items-center space-x-2 hover:text-emerald-600"
                    >
                        <i class="fa fa-home w-5 h-5 text-gray-500"></i>
                        <span>Dashboard</span>
                    </x-nav-link>

                    <x-nav-link 
                        href="{{ route('transactions.index') }}" 
                        :active="request()->routeIs('transactions.*')" 
                        class="flex items-center space-x-2 hover:text-emerald-600"
                    >
                        <i class="fa fa-credit-card w-5 h-5 text-gray-500"></i>
                        <span>Transactions</span>
                    </x-nav-link>

                    <x-nav-link 
                        href="{{ route('categories.index') }}" 
                        :active="request()->routeIs('categories.*')" 
                        class="flex items-center space-x-2 hover:text-emerald-600"
                    >
                        <i class="fa fa-tags w-5 h-5 text-gray-500"></i>
                        <span>Categories</span>
                    </x-nav-link>
                </div>
            </div>

            <!-- Right Section -->
            <div class="hidden sm:flex items-center space-x-4">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button 
                            class="flex items-center space-x-2 px-3 py-2 border border-gray-200 bg-gradient-to-r from-emerald-500 to-blue-500 text-white text-sm font-semibold rounded-xl hover:shadow-lg hover:from-emerald-600 hover:to-blue-600 transition-all duration-300"
                        >
                            <div class="w-8 h-8 rounded-full overflow-hidden border border-white/30 shadow-sm hover:scale-105 transition-transform duration-300">
    <img src="{{ Auth::user()->profile_photo_url }}" alt="Avatar" class="w-full h-full object-cover">
</div>

                            <span>{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-2 border-b border-gray-100 bg-gray-50">
                            <div class="text-xs text-gray-500">Signed in as</div>
                            <div class="text-sm font-semibold text-gray-800">{{ Auth::user()->email }}</div>
                        </div>

                        <x-dropdown-link href="{{ route('profile.edit') }}" class="flex items-center space-x-2">
                            <i class="fa fa-user w-5 h-5 text-gray-500"></i>
                            <span>Profile</span>
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link 
                                href="{{ route('logout') }}" 
                                onclick="event.preventDefault(); this.closest('form').submit();" 
                                class="flex items-center space-x-2 text-red-600 hover:bg-red-50"
                            >
                                <i class="fa fa-sign-out w-5 h-5"></i>
                                <span>Log Out</span>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="flex items-center sm:hidden">
                <button 
                    @click="open = ! open" 
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-emerald-600 hover:bg-gray-100 focus:outline-none"
                >
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden bg-white/90 backdrop-blur-md border-t border-gray-200">
        <div class="px-4 py-3 space-y-2">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>

            <x-responsive-nav-link href="{{ route('transactions.index') }}" :active="request()->routeIs('transactions.*')">
                Transactions
            </x-responsive-nav-link>

            <x-responsive-nav-link href="{{ route('categories.index') }}" :active="request()->routeIs('categories.*')">
                Categories
            </x-responsive-nav-link>
        </div>

        <div class="border-t border-gray-200 mt-3 pt-3 px-4 pb-3 bg-gray-50/70">
            <div class="text-gray-800 font-semibold">{{ Auth::user()->name }}</div>
            <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>

            <div class="mt-3 space-y-2">
                <x-responsive-nav-link href="{{ route('profile.edit') }}">
                    Profile
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link 
                        href="{{ route('logout') }}" 
                        onclick="event.preventDefault(); this.closest('form').submit();" 
                        class="text-red-600"
                    >
                        Log Out
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

