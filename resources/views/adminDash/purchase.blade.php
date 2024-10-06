@extends('components.layoutDash')

@section('dash')
<div class="bg-gray-100 flex justify-center items-center min-h-screen py-4 px-2">

    <div class="w-full max-w-md bg-white shadow-md rounded-lg p-6 md:p-8">
        <h2 class="text-2xl font-semibold text-center mb-6">Purchase Product</h2>

        @if (session('success'))
        <div class="mb-4 p-3 text-green-600 bg-green-200 rounded">
            {{ session('success') }}
        </div>
    @endif

        <form action="{{ route('buy') }}" method="post">
            @csrf

            <!-- Customer Name -->
            <div class="mb-4">
                <label for="customer_name" class="block text-gray-700 font-medium mb-2">Customer Name</label>
                <input type="text" name="customer_name" id="customer_name" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
            </div>

            <!-- Product -->
            <div class="mb-4">
                <label for="product_id" class="block text-gray-700 font-medium mb-2">Select Product</label>
                <select name="product_id" id="product_id" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
                    <option value="" data-price="">Select a product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->product_Name }} - ${{ $product->price }}</option>
                    @endforeach
                </select>
            </div>

           <!-- Quantity -->

           <div class="mb-4">
            <label for="quantity" class="block text-gray-700 font-medium mb-2">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required min="1">
           </div>


            <!-- Price -->
            <div class="mb-4">
                <label for="price" class="block text-gray-700 font-medium mb-2">Price</label>
                <input type="number" name="price" id="price" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" readonly required>
            </div>

            <!-- Date and Time -->
            <div class="mb-4">
                <label for="purchase_date" class="block text-gray-700 font-medium mb-2">Date and Time</label>
                <input type="text" name="purchase_date" id="purchase_date" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 flatpickr" required>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="w-full bg-blue-500 text-white p-3 rounded-lg hover:bg-blue-600 transition duration-300">Submit Purchase</button>
            </div>

        </form>
    </div>
</div>

<!-- Include Flatpickr CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    function updatePrice() {
        var selectedOption = document.getElementById('product_id').options[document.getElementById('product_id').selectedIndex];
        var pricePerUnit = selectedOption.getAttribute('data-price');
        var quantity = document.getElementById('quantity').value;

        if (pricePerUnit && quantity) {
            var totalPrice = pricePerUnit * quantity;
            document.getElementById('price').value = totalPrice.toFixed(2); // Converts to two decimal places
        }
    }

    // Add event listeners
    document.getElementById('product_id').addEventListener('change', updatePrice);
    document.getElementById('quantity').addEventListener('input', updatePrice);

    // Initialize Flatpickr
    flatpickr("#purchase_date", {
        enableTime: true,
        dateFormat: "F j, Y H:i", // Format na gusto mong ipakita (e.g., "October 5, 2024 12:00")
    });
</script>
@endsection
