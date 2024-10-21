@extends('components.layoutUser')

@section('userDash')
<div class="min-h-screen flex items-center justify-center bg-[#CAF0F8] p-6">
    <div class="max-w-lg w-full bg-white shadow-xl rounded-lg overflow-hidden">
        <div class="bg-[#03045E] text-white py-4 px-6 text-center">
            <h2 class="text-2xl font-semibold">Change Password</h2>
        </div>

        <form action="{{ route('profile.updatePassword') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <div class="space-y-2">
                <label for="current_password" class="font-medium text-[#0077B6]">Current Password:</label>
                <input type="password" name="current_password" id="current_password"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none" required>
                @error('current_password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="new_password" class="font-medium text-[#0077B6]">New Password:</label>
                <input type="password" name="new_password" id="new_password"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none" required>
                @error('new_password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="new_password_confirmation" class="font-medium text-[#0077B6]">Confirm New Password:</label>
                <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none" required>
            </div>

            <div class="flex justify-center">
                <button type="submit"
                        class="bg-[#00B4D8] hover:bg-[#0077B6] text-white font-semibold py-2 px-4 rounded-full transition">
                    Update Password
                </button>
            </div>
        </form>

        @if(session('success'))
            <div class="bg-green-500 text-white text-center py-2 mt-4">
                {{ session('success') }}
            </div>
        @endif
    </div>
</div>
@endsection
