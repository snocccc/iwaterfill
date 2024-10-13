@extends('components.layoutUser')

@section('userDash')
<div class="bg-[#caf0f8] flex justify-center items-center min-h-screen py-12 px-4">
    <div class="w-full max-w-lg bg-white shadow-xl rounded-lg overflow-hidden">
        <div class="bg-gradient-to-r from-[#03045e] to-[#0077b6] text-white py-6 px-8">
            <h2 class="text-3xl font-bold text-center">Purchase Product</h2>
        </div>

        <div class="p-8">
            @if (session('success'))
            <div class="mb-6 p-4 text-[#03045e] bg-[#90e0ef] rounded-lg shadow-md">
                {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('userBuy') }}" method="post" class="space-y-6">
                @csrf

                <!-- Customer Name -->
                <div>
                    <label for="username" class="block text-[#03045e] font-semibold mb-2">Customer Name</label>
                    <input type="text" name="username" id="username"
                           class="w-full p-3 border-2 border-[#90e0ef] rounded-lg bg-[#f0f9ff] focus:outline-none focus:border-[#00b4d8] transition duration-300"
                           value="{{ auth()->user()->username }}" readonly required>
                </div>

                <!-- Product -->
                <div>
                    <label for="product_id" class="block text-[#03045e] font-semibold mb-2">Select Product</label>
                    <select name="product_id" id="product_id" class="w-full p-3 border-2 border-[#90e0ef] rounded-lg focus:outline-none focus:border-[#00b4d8] transition duration-300" required>
                        <option value="" data-price="">Select a product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->product_Name }} - ${{ $product->price }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Quantity -->
                <div>
                    <label for="quantity" class="block text-[#03045e] font-semibold mb-2">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="w-full p-3 border-2 border-[#90e0ef] rounded-lg focus:outline-none focus:border-[#00b4d8] transition duration-300" required min="1">
                </div>

                <!-- Price -->
                <div>
                    <label for="price" class="block text-[#03045e] font-semibold mb-2">Total Price</label>
                    <input type="number" name="price" id="price" class="w-full p-3 border-2 border-[#90e0ef] rounded-lg bg-[#f0f9ff] focus:outline-none focus:border-[#00b4d8] transition duration-300" readonly required>
                </div>

                <!-- Date and Time -->
                <div>
                    <label for="purchase_date" class="block text-[#03045e] font-semibold mb-2">Purchase Date and Time</label>
                    <input type="text" name="purchase_date" id="purchase_date" class="w-full p-3 border-2 border-[#90e0ef] rounded-lg focus:outline-none focus:border-[#00b4d8] transition duration-300 flatpickr" required>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" class="w-full bg-[#00b4d8] text-white p-4 rounded-lg hover:bg-[#0077b6] transition duration-300 font-semibold text-lg shadow-md">
                        Complete Purchase
                    </button>
                </div>
            </form>
        </div>
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
            document.getElementById('price').value = totalPrice.toFixed(2);
        }
    }

    // Add event listeners
    document.getElementById('product_id').addEventListener('change', updatePrice);
    document.getElementById('quantity').addEventListener('input', updatePrice);

    // Initialize Flatpickr
    flatpickr("#purchase_date", {
        enableTime: true,
        dateFormat: "F j, Y H:i",
        theme: "airbnb"
    });
</script>
@endsection
