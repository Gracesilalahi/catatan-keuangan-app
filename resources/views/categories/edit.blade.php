<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Category') }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form action="{{ route('categories.update', $category) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" class="mt-1 block w-full border rounded px-3 py-2" value="{{ old('name', $category->name) }}" required>
                        @error('name')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Type</label>
                        <select name="type" class="mt-1 block w-full border rounded px-3 py-2" required>
                            <option value="income" {{ $category->type === 'income' ? 'selected' : '' }}>Income</option>
                            <option value="expense" {{ $category->type === 'expense' ? 'selected' : '' }}>Expense</option>
                        </select>
                        @error('type')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('categories.index') }}" class="mr-2 px-4 py-2 rounded border">Cancel</a>
                        <button class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>