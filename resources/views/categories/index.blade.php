<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Categories') }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium">Your Categories</h3>
                    <a href="{{ route('categories.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Add Category</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($categories as $cat)
                        <div class="border rounded p-4 flex justify-between items-center">
                            <div>
                                <div class="text-sm text-gray-500">{{ ucfirst($cat->type) }}</div>
                                <div class="font-semibold">{{ $cat->name }}</div>
                            </div>
                            <div class="space-x-2">
                                <a href="{{ route('categories.edit', $cat) }}" class="text-blue-600">Edit</a>
                                <form action="{{ route('categories.destroy', $cat) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600">Delete</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>