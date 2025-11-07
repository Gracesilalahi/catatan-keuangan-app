<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- 🧩 Update Profile Info -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <!-- Foto Profil -->
                        <div class="mb-6">
                            <label class="block text-gray-700 font-semibold mb-2">Foto Profil</label>
                            <div class="flex items-center gap-4">
                                <img src="{{ Auth::user()->profile_photo_url }}" 
                                     class="w-20 h-20 rounded-full object-cover border border-gray-300 shadow-sm">
                                <input type="file" name="profile_photo"
                                    class="text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0
                                           file:text-sm file:font-semibold file:bg-emerald-100 file:text-emerald-700 hover:file:bg-emerald-200">
                            </div>
                            @error('profile_photo')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nama -->
                        <div class="mb-4">
                            <label class="block font-semibold text-gray-700 mb-1">Nama</label>
                            <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}"
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-400 focus:border-emerald-400">
                        </div>

                        <!-- Email -->
                        <div class="mb-6">
                            <label class="block font-semibold text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-400 focus:border-emerald-400">
                        </div>

                        <button type="submit"
                                class="px-5 py-2 bg-gradient-to-r from-emerald-500 to-blue-500 text-white font-semibold rounded-lg 
                                       hover:from-emerald-600 hover:to-blue-600 shadow-md transition-all">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Update Password -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
