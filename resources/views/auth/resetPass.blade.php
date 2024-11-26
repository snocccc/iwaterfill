@extends('components.layoutAuth')
@section('title', 'Reset Password')
@section('auth')
<div class="flex justify-center items-center min-h-screen bg-gradient-to-r from-[var(--color-dark-blue)] via-[var(--color-medium-blue)] to-[var(--color-light-blue)]">
    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-8 space-y-8">
        <h1 class="text-3xl font-extrabold text-center text-[var(--color-dark-blue)]">Reset Password</h1>

        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <!-- Error Message -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Reset Password Form -->
        <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
            @csrf
            <!-- Hidden Token -->
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="relative">
                <!-- Email Input -->
                <input
                    type="email"
                    name="email"
                    value="{{ old('email', request()->email) }}"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 outline-none text-gray-700 placeholder-gray-400"
                    placeholder="Enter your email address"
                    required
                >
                <label class="absolute left-3 -top-2.5 bg-white px-2 text-sm text-gray-600">
                    Email Address
                </label>
            </div>

            <div class="relative">
                <!-- New Password Input -->
                <input
                    type="password"
                    name="password"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 outline-none text-gray-700 placeholder-gray-400"
                    placeholder="Enter new password"
                    required
                >
                <label class="absolute left-3 -top-2.5 bg-white px-2 text-sm text-gray-600">
                    New Password
                </label>

                <!-- Password Length Hint -->
                <p class="mt-2 text-sm text-gray-500">Password must be at least 6 characters long.</p>
            </div>

            <div class="relative">
                <!-- Confirm Password Input -->
                <input
                    type="password"
                    name="password_confirmation"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 outline-none text-gray-700 placeholder-gray-400"
                    placeholder="Confirm new password"
                    required
                >
                <label class="absolute left-3 -top-2.5 bg-white px-2 text-sm text-gray-600">
                    Confirm Password
                </label>
            </div>

            <!-- Reset Password Button -->
            <button
                type="submit"
                class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-6 rounded-xl transition duration-300 ease-in-out transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 shadow-lg hover:shadow-xl"
            >
                Reset Password
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </form>
    </div>
</div>
@endsection
