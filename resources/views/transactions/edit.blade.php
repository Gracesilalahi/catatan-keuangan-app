<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-600 
                         bg-clip-text text-transparent tracking-wide drop-shadow-md">
                ✏️ Edit Transaction
            </h2>

            <a href="{{ route('transactions.index') }}" 
               class="inline-flex items-center gap-2 bg-gradient-to-r from-gray-800 via-gray-900 to-black 
                           text-white px-5 py-2.5 rounded-xl shadow-lg hover:shadow-2xl hover:scale-105 
                           transition-all duration-300 font-medium">
                ← Back
            </a>
        </div>
    </x-slot>

    <!-- 🌸 Background ungu soft elegan -->
    <div class="py-16 min-h-screen bg-gradient-to-br from-purple-200 via-purple-300 to-indigo-200 relative overflow-hidden">
        <div class="absolute top-20 left-1/4 w-72 h-72 bg-purple-400/30 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-10 right-1/4 w-80 h-80 bg-pink-400/30 rounded-full blur-3xl animate-pulse"></div>



        <div class="relative max-w-4xl mx-auto sm:px-6 lg:px-8 z-10">
           {{-- KOREKSI 1: Mengubah background form menjadi ungu soft yang lebih kontras --}}
           <div class="bg-purple-50/95 backdrop-blur-xl border border-purple-300 shadow-2xl 
                 rounded-3xl p-10 transition-all duration-500 hover:shadow-[0_0_45px_-10px_rgba(168,85,247,0.6)]">


                <h3 class="text-xl font-semibold text-purple-700 mb-8 text-center tracking-wide">
                    Update your transaction details below ✨
                </h3>

                <form method="POST" action="{{ route('transactions.update', $transaction->id) }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Date -->
                    <div>
                        {{-- KOREKSI 2: Mengubah label menjadi ungu tua (terlihat) --}}
                        <label for="date" class="block text-purple-700 font-semibold mb-2">Date</label>
                        <input type="date" name="transaction_date" id="transaction_date"
                            value="{{ old('transaction_date', $transaction->transaction_date ? $transaction->transaction_date->format('Y-m-d') : '') }}"

                            {{-- KOREKSI 3: Mengubah warna teks input menjadi ungu tua (text-purple-900) --}}
                            class="w-full bg-white text-purple-900 placeholder-gray-400 border-purple-300 
                                     rounded-2xl shadow-sm px-4 py-3 focus:ring-pink-400 focus:border-pink-400 
                                     focus:outline-none transition-all duration-200">
                        @error('transaction_date')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror

                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-purple-700 font-semibold mb-2">Description</label>
                        <input type="text" name="description" id="description"
                            placeholder="e.g. Monthly Internet Bill"
                            value="{{ old('description', $transaction->description) }}"
                            {{-- KOREKSI 3: Mengubah warna teks input menjadi ungu tua (text-purple-900) --}}
                            class="w-full bg-white text-purple-900 placeholder-gray-400 border-purple-300 
                                     rounded-2xl shadow-sm px-4 py-3 focus:ring-cyan-400 focus:border-cyan-400 
                                     focus:outline-none transition-all duration-200">
                        @error('description')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category" class="block text-purple-700 font-semibold mb-2">Category</label>
                        {{-- KOREKSI 3: Mengubah warna teks di SELECT --}}
                        <select name="category" id="category"
                                 class="w-full bg-white text-purple-900 border-purple-300 rounded-2xl shadow-sm 
                                         px-4 py-3 focus:ring-violet-400 focus:border-violet-400 
                                         focus:outline-none transition-all duration-200">
                            @foreach($categories as $category)
                                <option value="{{ $category->name }}" 
                                    {{ old('category', $transaction->category) == $category->name ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div>
                        <label for="type" class="block text-purple-700 font-semibold mb-2">Type</label>
                        {{-- KOREKSI 3: Mengubah warna teks di SELECT --}}
                        <select name="type" id="type"
                                 class="w-full bg-white text-purple-900 border-purple-300 rounded-2xl shadow-sm 
                                         px-4 py-3 focus:ring-fuchsia-400 focus:border-fuchsia-400 
                                         focus:outline-none transition-all duration-200">
                            <option value="income" {{ old('type', $transaction->type) == 'income' ? 'selected' : '' }}>Income</option>
                            <option value="expense" {{ old('type', $transaction->type) == 'expense' ? 'selected' : '' }}>Expense</option>
                        </select>
                        @error('type')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Amount -->
                    <div>
                        <label for="amount" class="block text-purple-700 font-semibold mb-2">Amount (Rp)</label>
                        <input type="number" name="amount" id="amount"
                            placeholder="e.g. 250000"
                            value="{{ old('amount', $transaction->amount) }}"
                            {{-- KOREKSI 3: Mengubah warna teks input menjadi ungu tua (text-purple-900) --}}
                            class="w-full bg-white text-purple-900 placeholder-gray-400 border-purple-300 
                                     rounded-2xl shadow-sm px-4 py-3 focus:ring-emerald-400 focus:border-emerald-400 
                                     focus:outline-none transition-all duration-200">
                        @error('amount')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Current Receipt -->
                    @if ($transaction->receipt_image)
                        <div class="mt-4">
                            <label class="block text-purple-700 font-semibold mb-2">Current Receipt</label>
                            <img src="{{ asset('storage/' . $transaction->receipt_image) }}" 
                                 alt="Current Receipt"
                                 class="rounded-2xl border border-purple-300 shadow-md w-48 hover:scale-105 
                                         transition-transform duration-300">
                        </div>
                    @endif

                    <!-- Upload New Receipt -->
                    <div>
                        <label for="receipt_image" class="block text-purple-700 font-semibold mb-2">Upload New Receipt (Optional)</label>
                        <input type="file" name="receipt_image" id="receipt_image"
                            {{-- KOREKSI 4: Memastikan input file terbaca dengan baik --}}
                            class="w-full bg-white/50 text-purple-900 border-purple-300 rounded-2xl shadow-sm 
                                     px-4 py-3 focus:ring-indigo-400 focus:border-indigo-400 
                                     focus:outline-none transition-all duration-200
                                     file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 
                                     file:bg-purple-400/30 file:text-purple-800 hover:file:bg-purple-400/50 
                                     transition-all duration-200">
                        @error('receipt_image')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- ✅ Submit Button -->
                   <div class="flex justify-center pt-8">
                      <button type="submit"
                              class="bg-gradient-to-r from-pink-500 via-purple-500 to-indigo-500 
                                     text-white font-semibold px-10 py-3.5 rounded-2xl shadow-2xl 
                                     border border-white/30 drop-shadow-md
                                     hover:shadow-[0_0_25px_rgba(236,72,153,0.6)] hover:scale-105 
                                     transition-all duration-300 tracking-wide
                                     [text-shadow:_0_1px_3px_rgba(0,0,0,0.3)]">
                            💾 <span class="drop-shadow-md">Save Changes</span>
                      </button>
                    </div>


                </form>
            </div>
        </div>
    </div>
</x-app-layout>