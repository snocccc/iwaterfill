<!-- resources/views/customer/profile.blade.php -->
@extends('components.layoutUser')

@section('userDash')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-cyan-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white shadow-lg rounded-2xl overflow-hidden">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-blue-900 to-blue-800 px-6 py-8">
                <div class="text-center">
                    <div class="h-24 w-24 rounded-full bg-white p-1 mx-auto mb-4">
                        <!-- Avatar placeholder - replace with actual avatar if available -->
                        <div class="h-full w-full rounded-full bg-blue-100 flex items-center justify-center">
                            <span class="text-2xl font-bold text-blue-800">
                                {{ strtoupper(substr($user->username, 0, 1)) }}
                            </span>
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold text-white">{{ $user->username }}'s Profile</h2>
                </div>
            </div>

            <!-- Profile Information -->
            <div class="divide-y divide-gray-200">
                <div class="grid grid-cols-1 gap-4 px-6 py-5">
                    @php
                        $profileFields = [
                            'Customer ID' => $user->id,
                            'Username' => $user->username,
                            'Email' => $user->email,
                            'Location' => $user->location,
                            'Phone Number' => $user->phone
                        ];
                    @endphp

                    @foreach($profileFields as $label => $value)
                        <div class="flex items-center justify-between py-3">
                            <dt class="text-sm font-medium text-gray-600">{{ $label }}</dt>
                            <dd class="text-sm font-semibold text-gray-900">{{ $value }}</dd>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="bg-gray-50 px-6 py-6">
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('profile.edit') }}"
                       class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                        Edit Profile
                    </a>
                    <a href="{{ route('profile.updatePassword') }}"
                       class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                        Change Password
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
