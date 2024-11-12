@extends('components.layoutUser')

@section('userDash')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-cyan-50">
    <div class="max-w-lg w-full bg-white shadow-xl rounded-lg overflow-hidden">
        <div class="bg-[#03045E] text-white py-4 px-6 text-center">
            <h2 class="text-2xl font-semibold">Edit Profile</h2>
        </div>

        <form action="{{ route('profile.update', $user->id) }}" method="POST" class="p-6 space-y-6">
            @csrf
            <div class="space-y-2">
                <label for="username" class="font-medium text-[#0077B6]">Username:</label>
                <input type="text" name="username" id="username" value="{{ $user->username }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none" required>
            </div>

            <div class="space-y-2">
                <label for="email" class="font-medium text-[#0077B6]">Email:</label>
                <input type="email" name="email" id="email" value="{{ $user->email }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none" required>
            </div>

            <div class="space-y-2">
                <label for="location" class="font-medium text-[#0077B6]">Location:</label>
                <input type="text" name="location" id="location" value="{{ $user->location }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none">
            </div>

            <div class="space-y-2">
                <label for="phone" class="font-medium text-[#0077B6]">Phone Number:</label>
                <input type="text" name="phone" id="phone" value="{{ $user->phone }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none">
            </div>

            <div class="flex justify-center">
                <button type="submit"
                        class="bg-[#00B4D8] hover:bg-[#0077B6] text-white font-semibold py-2 px-4 rounded-full transition">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
