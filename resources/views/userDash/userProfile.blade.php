<!-- resources/views/customer/profile.blade.php -->
@extends('components.layoutUser')

@section('userDash')
<div class="min-h-screen flex items-center justify-center bg-[#CAF0F8] p-6">
    <div class="max-w-lg w-full bg-white shadow-xl rounded-lg overflow-hidden">
        <div class="bg-[#03045E] text-white py-4 px-6 text-center">
            <h2 class="text-2xl font-semibold">User Profile</h2>
        </div>

        <div class="p-6 space-y-6">
            <div class="flex justify-between items-center">
                <span class="font-medium text-[#0077B6]">Customer ID:</span>
                <p class="text-gray-700">{{ $user->id }}</p>
            </div>

            <div class="flex justify-between items-center">
                <span class="font-medium text-[#0077B6]">Username:</span>
                <p class="text-gray-700">{{ $user->username }}</p>
            </div>

            <div class="flex justify-between items-center">
                <span class="font-medium text-[#0077B6]">Email:</span>
                <p class="text-gray-700">{{ $user->email }}</p>
            </div>

            <div class="flex justify-between items-center">
                <span class="font-medium text-[#0077B6]">Location:</span>
                <p class="text-gray-700">{{ $user->location }}</p>
            </div>

            <div class="flex justify-between items-center">
                <span class="font-medium text-[#0077B6]">Phone Number:</span>
                <p class="text-gray-700">{{ $user->phone_number }}</p>
            </div>
        </div>

        <div class="bg-[#90E0EF] py-4 flex justify-center">
            <a href=""
               class="bg-[#00B4D8] hover:bg-[#0077B6] text-white font-semibold py-2 px-4 rounded-full transition">
                Edit Profile
            </a>
        </div>
    </div>
</div>
@endsection
