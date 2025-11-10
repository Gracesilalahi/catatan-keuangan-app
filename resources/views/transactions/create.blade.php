<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl bg-gradient-to-r from-emerald-600 via-blue-600 to-indigo-600 bg-clip-text text-transparent tracking-wide">
                Add New Transaction
            </h2>

            <a href="{{ route('transactions.index') }}" 
               class="inline-flex items-center gap-2 bg-gradient-to-r from-gray-600 to-gray-800 text-white px-5 py-2.5 rounded-xl shadow-md hover:shadow-lg hover:scale-105 transition-all duration-200 font-medium">
                ← Back
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-gray-50 via-white to-gray-100 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/80 backdrop-blur-lg shadow-2xl rounded-3xl p-10 border border-gray-100 hover:shadow-[0_0_40px_-10px_rgba(16,185,129,0.3)] transition-all duration-300">

                <h3 class="text-xl font-semibold text-gray-800 mb-8 text-center">
                    Fill in the details below ✨
                </h3>

                <form method="POST" action="{{ route('transactions.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                   <!-- Date -->
<div>
    <label for="transaction_date" class="block text-gray-700 font-semibold mb-2">Date</label>
    <input type="date" name="transaction_date" id="transaction_date" 
           value="{{ old('transaction_date') }}"
           class="w-full border-gray-300 rounded-2xl shadow-sm px-4 py-3 focus:ring-emerald-300 focus:border-emerald-400 transition">
    @error('transaction_date') 
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
    @enderror
</div>


                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-gray-700 font-semibold mb-2">Description</label>
                        <input type="text" name="description" id="description" 
                               placeholder="e.g. Salary, Electricity Bill, etc."
                               value="{{ old('description') }}"
                               class="w-full border-gray-300 rounded-2xl shadow-sm px-4 py-3 focus:ring-blue-300 focus:border-blue-400 transition">
                        @error('description') 
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category" class="block text-gray-700 font-semibold mb-2">Category</label>
                        <select name="category" id="category"
                                class="w-full border-gray-300 rounded-2xl shadow-sm px-4 py-3 focus:ring-indigo-300 focus:border-indigo-400 transition">
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->name }}" 
                                        {{ old('category') == $category->name ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category') 
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
                        @enderror
                    </div>

                    <!-- Type -->
                    <div>
                        <label for="type" class="block text-gray-700 font-semibold mb-2">Type</label>
                        <select name="type" id="type"
                                class="w-full border-gray-300 rounded-2xl shadow-sm px-4 py-3 focus:ring-purple-300 focus:border-purple-400 transition">
                            <option value="">-- Select Type --</option>
                            <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>Income</option>
                            <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>Expense</option>
                        </select>
                        @error('type') 
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
                        @enderror
                    </div>

                    <!-- Amount -->
                    <div>
                        <label for="amount" class="block text-gray-700 font-semibold mb-2">Amount (Rp)</label>
                        <input type="number" name="amount" id="amount"
                               placeholder="e.g. 100000"
                               value="{{ old('amount') }}"
                               class="w-full border-gray-300 rounded-2xl shadow-sm px-4 py-3 focus:ring-emerald-300 focus:border-emerald-400 transition">
                        @error('amount') 
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
                        @enderror
                    </div>

                    <!-- Receipt -->
                    <div>
                        <label for="receipt_image" class="block text-gray-700 font-semibold mb-2">Upload Receipt (Optional)</label>
                        <input type="file" name="receipt_image" id="receipt_image"
                               class="w-full border-gray-300 rounded-2xl shadow-sm px-4 py-3 focus:ring-pink-300 focus:border-pink-400 transition file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-emerald-100 file:text-emerald-700 hover:file:bg-emerald-200">
                        @error('receipt_image') 
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p> 
                        @enderror
                    </div>

                    <!-- Submit -->
                    <div class="flex justify-center pt-6">
  <button type="submit"
      class="bg-gradient-to-r from-emerald-500 via-green-500 to-teal-600 
             text-white font-semibold px-10 py-3.5 rounded-2xl shadow-lg 
             hover:shadow-xl hover:scale-105 transition-all duration-200
             [text-shadow:_0_1px_3px_rgba(0,0,0,0.3)]">
      + Save Transaction
  </button>
</div>

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
