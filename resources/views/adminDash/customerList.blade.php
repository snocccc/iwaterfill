@extends('components.layoutDash')
@section('title', 'Customer List')
@section('dash')
<div class="p-4 sm:p-6 bg-gradient-to-br from-blue-50 to-cyan-50 min-h-screen">
    <div class="bg-white rounded-lg shadow-xl overflow-hidden">
        <div class="p-4 sm:p-6 bg-gradient-to-r from-[#03045e] to-[#0077b6]">
            <h1 class="text-xl sm:text-2xl font-bold text-white">Customer List</h1>
        </div>


            <!-- Desktop View (table) - Hidden on mobile -->
            <div class="hidden md:block overflow-x-auto bg-white rounded-lg shadow">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($users as $user)
                        <tr class="hover:bg-gray-50 transition duration-300">
                            <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->username }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">{{ $user->location }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">{{ $user->phone }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile View (cards) - Shown only on mobile -->
            <div class="md:hidden space-y-4">
                @foreach($users as $user)
                <div class="bg-white rounded-lg shadow p-4 border border-gray-200">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-medium text-gray-900">{{ $user->username }}</h3>

                    </div>
                    <div class="space-y-1 text-sm">
                        <p class="flex items-center text-gray-500">
                            <i class="ri-mail-line mr-2"></i>
                            {{ $user->email }}
                        </p>
                        <p class="flex items-center text-gray-500">
                            <i class="ri-map-pin-line mr-2"></i>
                            {{ $user->location }}
                        </p>
                        <p class="flex items-center text-gray-500">
                            <i class="ri-phone-line mr-2"></i>
                            {{ $user->phone }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
