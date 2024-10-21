@extends('components.layoutDash')

@section('dash')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">
                Welcome back, {{ auth()->user()->username }}
            </h1>
            <p class="mt-2 text-sm text-gray-600">
                Manage your inventory and container transactions
            </p>
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
                        <h2 class="text-lg font-semibold text-gray-900">Product Quantities</h2>
                        <button onclick="toggleForm('editForm')" class="text-sm text-indigo-600 hover:text-indigo-900">
                            Edit
                        </button>
                    </div>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($allProducts as $product)
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-sm font-medium text-gray-900">{{ $product->product_Name }}</span>
                                <span class="text-sm text-gray-700">{{ $product->stock }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <div id="editForm" style="display: none;" class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Edit Quantities</h2>
                </div>
                <form action="{{ route('updateProducts') }}" method="POST" class="p-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($allProducts as $product)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">{{ $product->product_Name }}</label>
                                <input type="number" name="stock[{{ $product->id }}]" value="{{ $product->stock }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Available Containers Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Available Containers</h2>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($containers as $container)
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-sm font-medium text-gray-900">{{ $container->product_Name }}</span>
                                <span class="text-sm text-gray-700">{{ $container->availableCon }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="grid grid-cols-2 gap-4">
                <button onclick="toggleForm('borrowForm'); hideForm('returnForm')"
                        class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Borrow Container
                </button>
                <button onclick="toggleForm('returnForm'); hideForm('borrowForm')"
                        class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Return Container
                </button>
            </div>

            <!-- Borrow Form -->
            <div id="borrowForm" style="display: none;" class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Borrow Container</h2>
                </div>
                <form action="{{ route('borrowContainer') }}" method="POST" class="p-4">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="product_name" class="block text-sm font-medium text-gray-700">Select Container</label>
                            <select name="product_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @foreach($containers as $container)
                                    <option value="{{ $container->product_Name }}">{{ $container->product_Name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="borrow_quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                            <input type="number" name="borrow_quantity" min="1" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Confirm Borrow
                        </button>
                    </div>
                </form>
            </div>

            <!-- Return Form -->
            <div id="returnForm" style="display: none;" class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Return Container</h2>
                </div>
                <form action="{{ route('returnContainer') }}" method="POST" class="p-4">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="return_product_name" class="block text-sm font-medium text-gray-700">Select Container</label>
                            <select name="return_product_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @foreach($containers as $container)
                                    <option value="{{ $container->product_Name }}">{{ $container->product_Name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="return_quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                            <input type="number" name="return_quantity" min="1" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Confirm Return
                        </button>
                    </div>
                </form>
            </div>
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
