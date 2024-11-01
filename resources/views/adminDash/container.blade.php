@extends('components.layoutDash')

@section('dash')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="mb-8 flex items-center">
            <svg class="h-8 w-8 text-indigo-600 mr-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                <polyline points="9 22 9 12 15 12 15 22"/>
            </svg>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Welcome back, {{ auth()->user()->username }}
                </h1>
                <p class="mt-2 text-sm text-gray-600">
                    Manage your inventory and container transactions
                </p>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-lg bg-green-50 p-4 border-l-4 border-green-400">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="space-y-6">
            <!-- Product Quantities Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-gray-500 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4"/>
                                <path d="M4 6v12c0 1.1.9 2 2 2h14v-4"/>
                                <path d="M18 12c0-1.1-.9-2-2-2H4"/>
                            </svg>
                            <h2 class="text-lg font-semibold text-gray-900">Product Quantities</h2>
                        </div>
                        <button onclick="toggleForm('editForm')" class="flex items-center text-sm text-indigo-600 hover:text-indigo-900">
                            <svg class="h-4 w-4 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                            Edit
                        </button>
                    </div>
                </div>
                <!-- Rest of Product Quantities section remains the same -->
            </div>

            <!-- Available Containers Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-4 border-b border-gray-200">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-gray-500 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"/>
                            <line x1="12" y1="22.08" x2="12" y2="12"/>
                        </svg>
                        <h2 class="text-lg font-semibold text-gray-900">Available Containers</h2>
                    </div>
                </div>
                <!-- Rest of Available Containers section remains the same -->
            </div>

            <!-- Action Buttons -->
            <div class="grid grid-cols-2 gap-4">
                <button onclick="toggleForm('borrowForm'); hideForm('returnForm')"
                        class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 14v6a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-6"/>
                        <polyline points="12 3 12 15"/>
                        <path d="M5 8l7-5 7 5"/>
                    </svg>
                    Borrow Container
                </button>
                <button onclick="toggleForm('returnForm'); hideForm('borrowForm')"
                        class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 10v6a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-6"/>
                        <polyline points="12 21 12 9"/>
                        <path d="M5 16l7 5 7-5"/>
                    </svg>
                    Return Container
                </button>
            </div>

            <!-- Forms remain the same -->
        </div>
    </div>
</div>

<script>
    function toggleForm(formId) {
        var form = document.getElementById(formId);
        if (form) {
            form.style.display = form.style.display === "none" ? "block" : "none";
        }
    }

    function hideForm(formId) {
        var form = document.getElementById(formId);
        if (form) {
            form.style.display = "none";
        }
    }
</script>
@endsection
