@extends('components.layoutUser')

@section('userDash')
<div class="bg-gradient-to-br from-blue-50 to-cyan-50 min-h-screen py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <div class="bg-white shadow-2xl rounded-lg overflow-hidden">
            <div class="bg-gradient-to-r from-[#03045e] to-[#0077b6] p-4 sm:p-6">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-white text-center">Purchase Product</h2>
            </div>

            @if (session('success'))
            <div class="m-4 p-3 bg-[#90e0ef] text-[#03045e] rounded-md">
                {{ session('success') }}
            </div>
            @endif

            @if (session('error'))
            <div class="m-4 p-3 bg-red-500 text-white rounded-md">
                {{ session('error') }}
            </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                @foreach($products as $product)
                <div class="bg-white p-6 rounded-lg shadow-md cursor-pointer" onclick="toggleDropdown('{{ $product->id }}')">
                    <!-- Image for the product -->
                    <img src="{{ asset('images/' . $product->image_url . '.png') }}" alt="{{ $product->product_Name }}" class="w-full h-48 object-cover rounded-lg mb-4">

                    <h3 class="text-xl font-bold text-[#03045e]">{{ $product->product_Name }}</h3>
                    <p class="text-sm text-gray-600">{{ $product->description }}</p>
                    <p class="mt-2 text-md font-semibold">
                        Available Inventory: <span class="text-[#0077b6]">{{ $product->stock }}</span>
                    </p>
                    <p class="text-lg font-bold mt-4 text-[#023e8a]">₱{{ number_format($product->price, 2) }}</p>

                    <!-- Form Section -->
                    <form action="{{ route('userBuy') }}" method="post" class="p-4 space-y-4 hidden" id="form-{{ $product->id }}" onsubmit="return validateForm('{{ $product->id }}')">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <!-- Username Input -->
                        <label for="username-{{ $product->id }}" class="block text-sm font-medium text-[#03045e]">Customer Name</label>
                        <input type="text" id="username-{{ $product->id }}" name="username"
                               class="w-full border-2 border-[#90e0ef] rounded-md py-2 px-3 focus:outline-none focus:ring-[#00b4d8] focus:border-[#00b4d8] transition duration-300"
                               value="{{ auth()->user()->username }}" readonly>

                        <!-- Quantity Input -->
                        <label for="quantity-{{ $product->id }}" class="block text-sm font-medium text-[#03045e] mt-4">Quantity</label>
                        <input type="number" id="quantity-{{ $product->id }}" name="quantity" min="1" max="{{ $product->stock }}"
                               class="w-full border-2 border-[#90e0ef] rounded-md py-2 px-3 focus:outline-none focus:ring-[#00b4d8] focus:border-[#00b4d8] transition duration-300"
                               oninput="updateTotalPrice('{{ $product->id }}', {{ $product->price }})">

                        <p class="mt-2">Total Price: ₱<span id="total-price-{{ $product->id }}">0.00</span></p>

                        <button type="submit"
                                class="w-full py-2 px-4 bg-[#00b4d8] text-white rounded-md hover:bg-[#0077b6] transition duration-300">
                            Checkout
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle the visibility of the product's form
    function toggleDropdown(productId) {
        // Hide all forms first
        document.querySelectorAll('[id^="form-"]').forEach(form => form.classList.add('hidden'));

        // Show the clicked product's form
        const form = document.getElementById(`form-${productId}`);
        form.classList.toggle('hidden');
    }

    // Update the total price dynamically based on quantity input
    function updateTotalPrice(productId, pricePerUnit) {
        const quantity = parseInt(document.getElementById(`quantity-${productId}`).value) || 0;
        const totalPrice = pricePerUnit * quantity;
        document.getElementById(`total-price-${productId}`).textContent = totalPrice.toFixed(2);
    }

    // Validate the form to ensure a valid quantity and username are entered
    function validateForm(productId) {
        const username = document.getElementById(`username-${productId}`).value;
        const quantity = document.getElementById(`quantity-${productId}`).value;

        if (!username) {
            alert('Please enter the customer\'s name.');
            return false;
        }

        if (!quantity || quantity <= 0) {
            alert('Please enter a valid quantity.');
            return false;
        }
        return true;
    }
</script>
@endsection
