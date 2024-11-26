@extends('components.layoutUser')

@section('userDash')
<div class="min-h-screen bg-gradient-to-b from-sky-50 to-blue-100 flex items-center justify-center p-4 sm:p-6">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg overflow-hidden border border-blue-100">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-5">
            <h2 class="text-2xl font-bold text-white text-center">
                Change Password
            </h2>
        </div>

        <!-- Form Section -->
        <form action="{{ route('profile.updatePassword') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <!-- Current Password -->
            <div class="space-y-2">
                <label for="current_password" class="block text-sm font-semibold text-blue-900">
                    Current Password
                </label>
                <div class="relative">
                    <input type="password"
                           name="current_password"
                           id="current_password"
                           class="w-full px-4 py-2.5 rounded-lg border border-blue-200 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition-all duration-200"
                           required>
                </div>
                @error('current_password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- New Password -->
            <div class="space-y-2">
                <label for="new_password" class="block text-sm font-semibold text-blue-900">
                    New Password
                </label>
                <input type="password"
                       name="new_password"
                       id="new_password"
                       class="w-full px-4 py-2.5 rounded-lg border border-blue-200 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition-all duration-200"
                       required>
                @error('new_password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm New Password -->
            <div class="space-y-2">
                <label for="new_password_confirmation" class="block text-sm font-semibold text-blue-900">
                    Confirm New Password
                </label>
                <input type="password"
                       name="new_password_confirmation"
                       id="new_password_confirmation"
                       class="w-full px-4 py-2.5 rounded-lg border border-blue-200 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition-all duration-200"
                       required>
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg active:scale-98">
                    Update Password
                </button>
            </div>
        </form>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mx-6 mb-6 p-4 bg-green-100 border border-green-200 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif
    </div>
</div>
@endsection
