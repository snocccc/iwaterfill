@extends('components.layoutDash')

@section('dash')
<section class="py-12 bg-[#caf0f8]">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-xl">
        <h1 class="text-3xl font-bold mb-6 text-[#03045e] text-center">Add New Product</h1>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p class="font-bold">Success!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <form action="{{ route('addProduct') }}" method="post" class="space-y-6">
            @csrf
            <!-- Product Name -->
            <div>
                <label for="product-name" class="block text-sm font-medium text-[#03045e] mb-1">Product Name</label>
                <input type="text" id="product-name" name="product-name" required
                    class="w-full px-3 py-2 border-2 border-[#90e0ef] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00b4d8] focus:border-[#00b4d8] transition"
                    placeholder="Enter product name">
            </div>

            <!-- Product Description -->
            <div>
                <label for="product-description" class="block text-sm font-medium text-[#03045e] mb-1">Product Description</label>
                <textarea id="product-description" name="product-description" required rows="4"
                    class="w-full px-3 py-2 border-2 border-[#90e0ef] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00b4d8] focus:border-[#00b4d8] transition"
                    placeholder="Describe your product"></textarea>
            </div>

            <!-- Price and Stock Quantity (side by side) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="price" class="block text-sm font-medium text-[#03045e] mb-1">Price ($)</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">$</span>
                        </div>
                        <input type="number" id="price" name="price" required min="0" step="0.01"
                            class="w-full pl-7 pr-12 py-2 border-2 border-[#90e0ef] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#00b4d8] focus:border-[#00b4d8] transition"
                            placeholder="0.00">
                    </div>
                </div>

                <div>
                    <label for="stock" class="block text-sm font-medium text-[#03045e] mb-1">Stock Quantity</label>
                    <input type="number" id="stock" name="stock" required min="0"
                        class="w-full px-3 py-2 border-2 border-[#90e0ef] rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-[#00b4d8] focus:border-[#00b4d8] transition"
                        placeholder="Enter quantity">
                </div>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="w-full bg-[#0077b6] hover:bg-[#00b4d8] text-white font-bold py-3 px-4 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-[#00b4d8] focus:ring-opacity-50 transition duration-300 ease-in-out transform hover:-translate-y-1">
                    Add Product
                </button>
            </div>
        </form>
    </div>
</section>
@endsection
