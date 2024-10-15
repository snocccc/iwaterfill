@extends('components.layoutDash')

@section('dash')
<section class="min-h-screen bg-gradient-to-b from-[#caf0f8] to-[#90e0ef] p-6">
    <div class="max-w-4xl mx-auto">
        <div class="text-2xl font-bold text-center mb-6 text-[#03045e]">
            <h1>Welcome, {{ auth()->user()->username }}!</h1>
        </div>

        @if(session('success'))
            <div class="px-4 py-3 rounded-lg mb-6 bg-[#90e0ef] border-l-4 border-[#00b4d8] text-[#03045e]">
                <p class="font-medium">Success!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <div class="space-y-6">
            <!-- Section for Total Quantity of Each Product -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-[#0077b6] to-[#00b4d8] px-4 py-3">
                    <h3 class="font-bold text-lg text-white flex justify-between items-center">
                        Total Quantity of Each Product
                        <button onclick="toggleForm('editForm')" class="text-sm focus:outline-none hover:text-[#caf0f8] transition duration-300">
                            Edit
                        </button>
                    </h3>
                </div>
                <div class="p-4">
                    <ul class="space-y-2">
                        @foreach($allProducts as $product)
                            <li class="text-gray-700">
                                <span class="font-medium">{{ $product->product_Name }}:</span>
                                <span class="text-[#03045e]">{{ $product->stock }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Edit Form for Total Quantity -->
            <div id="editForm" style="display: none;" class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-[#0077b6] to-[#00b4d8] px-4 py-3">
                    <h3 class="font-bold text-lg text-white">Edit Product Quantities</h3>
                </div>
                <form action="{{ route('updateProducts') }}" method="POST" class="p-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($allProducts as $product)
                            <div>
                                <label class="block text-sm font-medium text-[#03045e] mb-1">{{ $product->product_Name }}:</label>
                                <input type="number" name="stock[{{ $product->id }}]" value="{{ $product->stock }}"
                                       class="w-full border rounded-md p-2 text-sm focus:ring-2 focus:ring-[#00b4d8] focus:border-transparent transition duration-300"
                                       style="border-color: #90e0ef;">
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="px-4 py-2 bg-[#0077b6] text-white rounded-md hover:bg-[#03045e] transition duration-300">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

            <!-- Section for Available Containers -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-[#0077b6] to-[#00b4d8] px-4 py-3">
                    <h3 class="font-bold text-lg text-white">Available Containers</h3>
                </div>
                <div class="p-4">
                    <ul class="space-y-2">
                        @foreach($containers as $container)
                            <li class="text-gray-700">
                                <span class="font-medium">{{ $container->product_Name }}:</span>
                                <span class="text-[#03045e]">{{ $container->availableCon }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Borrow and Return Buttons -->
            <div class="flex space-x-4">
                <button onclick="toggleForm('borrowForm'); hideForm('returnForm')"
                        class="flex-1 px-4 py-2 bg-[#00b4d8] text-white rounded-md hover:bg-[#0077b6] transition duration-300">
                    Borrow Container
                </button>
                <button onclick="toggleForm('returnForm'); hideForm('borrowForm')"
                        class="flex-1 px-4 py-2 bg-[#0077b6] text-white rounded-md hover:bg-[#03045e] transition duration-300">
                    Return Container
                </button>
            </div>

            <!-- Borrow Form -->
            <div id="borrowForm" style="display: none;" class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-[#0077b6] to-[#00b4d8] px-4 py-3">
                    <h3 class="font-bold text-lg text-white">Borrow Container</h3>
                </div>
                <form action="{{ route('borrowContainer') }}" method="POST" class="p-4">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="product_name" class="block text-sm font-medium text-[#03045e] mb-1">Select Container:</label>
                            <select name="product_name" class="w-full border rounded-md p-2 text-sm focus:ring-2 focus:ring-[#00b4d8] focus:border-transparent transition duration-300"
                                    style="border-color: #90e0ef;">
                                @foreach($containers as $container)
                                    <option value="{{ $container->product_Name }}">{{ $container->product_Name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="borrow_quantity" class="block text-sm font-medium text-[#03045e] mb-1">Quantity:</label>
                            <input type="number" name="borrow_quantity" min="1" required
                                   class="w-full border rounded-md p-2 text-sm focus:ring-2 focus:ring-[#00b4d8] focus:border-transparent transition duration-300"
                                   style="border-color: #90e0ef;">
                        </div>
                        <button type="submit" class="w-full px-4 py-2 bg-[#00b4d8] text-white rounded-md hover:bg-[#0077b6] transition duration-300">
                            Confirm Borrow
                        </button>
                    </div>
                </form>
            </div>

            <!-- Return Form -->
            <div id="returnForm" style="display: none;" class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-[#0077b6] to-[#00b4d8] px-4 py-3">
                    <h3 class="font-bold text-lg text-white">Return Container</h3>
                </div>
                <form action="{{ route('returnContainer') }}" method="POST" class="p-4">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="return_product_name" class="block text-sm font-medium text-[#03045e] mb-1">Select Container:</label>
                            <select name="return_product_name" class="w-full border rounded-md p-2 text-sm focus:ring-2 focus:ring-[#00b4d8] focus:border-transparent transition duration-300"
                                    style="border-color: #90e0ef;">
                                @foreach($containers as $container)
                                    <option value="{{ $container->product_Name }}">{{ $container->product_Name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="return_quantity" class="block text-sm font-medium text-[#03045e] mb-1">Quantity:</label>
                            <input type="number" name="return_quantity" min="1" required
                                   class="w-full border rounded-md p-2 text-sm focus:ring-2 focus:ring-[#00b4d8] focus:border-transparent transition duration-300"
                                   style="border-color: #90e0ef;">
                        </div>
                        <button type="submit" class="w-full px-4 py-2 bg-[#0077b6] text-white rounded-md hover:bg-[#03045e] transition duration-300">
                            Confirm Return
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    function toggleForm(formId) {
        var form = document.getElementById(formId);
        form.style.display = form.style.display === "none" ? "block" : "none";
    }

    function hideForm(formId) {
        document.getElementById(formId).style.display = "none";
    }
</script>
@endsection
