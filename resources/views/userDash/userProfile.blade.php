@extends('components.layoutUser')

@section('title', 'User Dashboard')

@section('userDash')
<div class="space-y-8 p-6 bg-gradient-to-br from-blue-50 to-cyan-50 p-6">
    <!-- Personal Information -->
    <div class="bg-white rounded-2xl shadow-lg p-8 border border-blue-100 transition-transform hover:scale-[1.01] duration-300">
        <div class="flex items-center space-x-3 mb-6">
            <div class="bg-blue-600 p-2 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800">Personal Information</h2>
        </div>

 <!-- Action Buttons -->
 <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-100 mt-8">
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="{{ route('profile.edit') }}"
           class="inline-flex items-center justify-center px-6 py-3 text-sm font-medium rounded-xl text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 shadow-lg hover:shadow-xl">
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
            </svg>
            Edit Profile
        </a>
        <a href="{{ route('profile.updatePassword') }}"
           class="inline-flex items-center justify-center px-6 py-3 text-sm font-medium rounded-xl text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
            </svg>
            Change Password
        </a>
    </div>
</div>
</div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
            <div class="bg-blue-50 p-4 rounded-xl">
                <p class="text-sm text-blue-600 font-medium mb-1">Full Name</p>
                <p class="text-lg font-semibold text-gray-800">{{ $user->username }}</p>
            </div>
            <div class="bg-blue-50 p-4 rounded-xl">
                <p class="text-sm text-blue-600 font-medium mb-1">Email</p>
                <p class="text-lg font-semibold text-gray-800">{{ $user->email }}</p>
            </div>
            <div class="bg-blue-50 p-4 rounded-xl">
                <p class="text-sm text-blue-600 font-medium mb-1">Phone</p>
                <p class="text-lg font-semibold text-gray-800">{{ $user->phone ?? 'Not provided' }}</p>
            </div>
            <div class="bg-blue-50 p-4 rounded-xl">
                <p class="text-sm text-blue-600 font-medium mb-1">Address</p>
                <p class="text-lg font-semibold text-gray-800">{{ $user->location ?? 'Not provided' }}</p>
            </div>
        </div>
    </div>

    <!-- Orders Cards Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Pending Orders -->
        <a href=" {{ route('user.pendingOrders') }}" class="block">
            <div class="bg-white rounded-2xl shadow-lg border border-blue-100 transition-transform hover:scale-[1.01] duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="bg-blue-600 p-2 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-gray-800">Pending Orders</h2>
                        </div>
                        <span class="text-2xl font-bold text-blue-600">{{ $pendingCount }}</span>
                    </div>
                    <p class="text-sm text-gray-600">You currently have {{ $pendingCount }} pending orders.</p>
                </div>
            </div>
        </a>


        <!-- Completed Orders -->
        <a href="{{ route('user.completedOrders')}}" class="block">
            <div class="bg-white rounded-2xl shadow-lg border border-blue-100 transition-transform hover:scale-[1.01] duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="bg-blue-600 p-2 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-gray-800">Completed Orders</h2>
                        </div>
                        <span class="text-2xl font-bold text-blue-600">{{ $completedCount }}</span>
                    </div>
                    <p class="text-sm text-gray-600">You have completed {{ $completedCount }} orders.</p>
                </div>
            </div>
        </a>

        <a href=" {{ route('user.cancelledOrders') }}" class="block">
            <div class="bg-white rounded-2xl shadow-lg border border-red-100 transition-transform hover:scale-[1.01] duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="bg-red-600 p-2 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 11-12.728 0m12.728 0L9 12m9-6.364L12 15"></path>
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold text-gray-800">Cancelled Orders</h2>
                        </div>
                        <span class="text-2xl font-bold text-red-600">{{ $cancelledCount }}</span>
                    </div>
                    <p class="text-sm text-gray-600">You have {{ $cancelledCount }} cancelled orders.</p>
                </div>
            </div>
        </a>


    </div>
</div>
@endsection
