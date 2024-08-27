@extends('components.layoutDash')

@section('dash')
<section>
    <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Add Product</h1>
        <form action="{{ route('addProduct') }}" method="post">
            @csrf
            <!-- Product Name -->
            <div class="mb-4">
                <label for="product-name" class="block text-gray-700 font-bold mb-2">Product Name</label>
                <input type="text" id="product-name" name="product-name" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Product Description -->
            <div class="mb-4">
                <label for="product-description" class="block text-gray-700 font-bold mb-2">Product Description</label>
                <textarea id="product-description" name="product-description" required rows="4"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <!-- Price -->
            <div class="mb-4">
                <label for="price" class="block text-gray-700 font-bold mb-2">Price ($)</label>
                <input type="number" id="price" name="price" required min="0" step="0.01"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <!-- Stock Quantity -->
            <div class="mb-4">
                <label for="stock" class="block text-gray-700 font-bold mb-2">Stock Quantity</label>
                <input type="number" id="stock" name="stock" required min="0"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>


            <!-- Submit Button -->
            <div>
                <button
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-md shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    Add Product
                </button>
            </div>
        </form>
    </div>
</section>
@endsection
