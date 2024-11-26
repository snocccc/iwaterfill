@extends('components.layoutDash')

@section('title', 'Account Settings')
@section('dash')

<div class="min-h-screen m-10">
    <div class="max-w-2xl mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-gray-900">Account Settings</h1>
            <p class="mt-2 text-gray-600">Manage your account preferences and security</p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 p-4 text-green-700 bg-green-100 rounded-lg">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
    <div class="bg-red-100 text-red-700 p-4 rounded-md mb-4">
        {{ session('error') }}
    </div>
@endif

        <!-- Main Content -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <!-- Profile Section -->
            <div class="mb-8">
                <div class="flex items-center justify-center mb-6">
                    <div class="relative">
                        <img src="{{ asset('images/logo.png') }}" alt="Profile Picture"
                             class="w-24 h-24 rounded-full border-4 border-blue-100">
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex flex-col items-center">
                        <h3 class="text-lg font-semibold text-gray-900">
                            {{ $user->email }}
                        </h3>
                    </div>
                </div>
            </div>

            <!-- Buttons Section -->
            <div class="space-y-4">
                <!-- Add Backup Account Button -->
                <button onclick="openBackupModal()" class="w-full bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition duration-200 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Backup Account
                </button>

                <!-- Change Password Button -->
                <a href="{{ route('adminUpdatepass')}}" class="w-full">
                    <button class="mt-2 w-full bg-white text-blue-500 px-6 py-3 rounded-lg border-2 border-blue-500 hover:bg-blue-50 transition duration-200 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                        Change Password
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>

<<!-- Backup Account Modal -->
<div id="backupModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full flex items-center justify-center">
    <div class="relative p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Add Backup Account</h3>
            <form action="{{ route('backup.store')}}" method="POST" class="space-y-4">
                @csrf
                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input type="email" name="email" id="email" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Username Input -->
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" name="username" id="username"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Location Input -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                    <input type="text" name="location" id="location"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Phone Input -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="phone" id="phone"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Confirm Password Input -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Modal Buttons -->
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeBackupModal()"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
function openBackupModal() {
    document.getElementById('backupModal').classList.remove('hidden');
}

function closeBackupModal() {
    document.getElementById('backupModal').classList.add('hidden');
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('backupModal');
    if (event.target == modal) {
        closeBackupModal();
    }
}
</script>

@endsection
