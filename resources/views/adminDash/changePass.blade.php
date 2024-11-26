@extends('components.layoutDash')

@section('title', 'Change Password')
@section('dash')

<div class="min-h-screen pt-6">
    <div class="max-w-md mx-auto">
        <!-- Card Container -->
        <div class="bg-white rounded-xl shadow-lg p-8 justify-center ">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-800">Change Password</h1>
                <p class="text-gray-500 mt-2">Please enter your current password and new password</p>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-50 text-green-600 px-4 py-3 rounded-lg text-sm mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('admin.updatePassword') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Current Password -->
                <div class="space-y-2">
                    <label for="current_password" class="text-sm font-medium text-gray-700 block">
                        Current Password
                    </label>
                    <div class="relative">
                        <input type="password"
                               id="current_password"
                               name="current_password"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                               required>
                    </div>
                </div>

                <!-- New Password -->
                <div class="space-y-2">
                    <label for="new_password" class="text-sm font-medium text-gray-700 block">
                        New Password
                    </label>
                    <div class="relative">
                        <input type="password"
                               id="new_password"
                               name="new_password"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                               required>
                    </div>
                </div>

                <!-- Confirm New Password -->
                <div class="space-y-2">
                    <label for="new_password_confirmation" class="text-sm font-medium text-gray-700 block">
                        Confirm New Password
                    </label>
                    <div class="relative">
                        <input type="password"
                               id="new_password_confirmation"
                               name="new_password_confirmation"
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                               required>
                    </div>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="bg-red-50 text-red-500 px-4 py-3 rounded-lg text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Update Password
                </button>
            </form>

            <!-- Back Link -->
            <div class="text-center mt-6">
                <a href="{{ route('settings') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                    Back to Settings
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
