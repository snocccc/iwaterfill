@extends('components.layoutUser')

@section('userDash')
<div class="min-h-screen flex items-center justify-center">
    <div class="w-full max-w-xl mx-4">
        <!-- Card Container -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-blue-100">
            <!-- Header -->
            <div class="bg-blue-600 py-6 px-8 relative">
                <h2 class="text-2xl font-bold text-white text-center">Edit Profile</h2>
                <div class="absolute bottom-0 left-0 w-full h-2 bg-gradient-to-r from-blue-400 to-blue-800"></div>
            </div>

            <!-- Form Section -->
            <form action="{{ route('profile.update') }}" method="POST" class="p-8">
                @csrf
                <div class="space-y-6">
                    <!-- Username Field -->
                    <div class="space-y-2">
                        <label for="username" class="block text-sm font-semibold text-blue-800">Username</label>
                        <input type="text"
                               name="username"
                               id="username"
                               value="{{ $user->username }}"
                               class="w-full px-4 py-3 rounded-xl border border-blue-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-blue-50/50"
                               required>
                    </div>

                    <!-- Email Field -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-semibold text-blue-800">Email Address</label>
                        <input type="email"
                               name="email"
                               id="email"
                               value="{{ $user->email }}"
                               class="w-full px-4 py-3 rounded-xl border border-blue-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-blue-50/50"
                               required>
                    </div>

                    <!-- Location Field -->
                    <div class="space-y-2">
                        <label for="location" class="block text-sm font-semibold text-blue-800">Location</label>
                        <input type="text"
                               name="location"
                               id="location"
                               value="{{ $user->location }}"
                               class="w-full px-4 py-3 rounded-xl border border-blue-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-blue-50/50">
                    </div>

                    <!-- Phone Field -->
                    <div class="space-y-2">
                        <label for="phone" class="block text-sm font-semibold text-blue-800">Phone Number</label>
                        <input type="text"
                               name="phone"
                               id="phone"
                               value="{{ $user->phone }}"
                               class="w-full px-4 py-3 rounded-xl border border-blue-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-blue-50/50">
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 transform hover:-translate-y-0.5 hover:shadow-lg">
                            Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
