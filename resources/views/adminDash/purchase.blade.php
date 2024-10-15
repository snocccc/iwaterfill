@extends('components.layoutDash')

@section('dash')
<div class="bg-[#caf0f8] min-h-screen py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow-2xl rounded-lg overflow-hidden">
            <div class="bg-gradient-to-r from-[#03045e] to-[#0077b6] p-4 sm:p-6">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-white text-center">Purchase Product</h2>
            </div>

            @if (session('success'))
            <div class="m-4 p-3 bg-[#90e0ef] text-[#03045e] rounded-md">
                {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('buy') }}" method="post" class="p-4 sm:p-6 space-y-4">
                @csrf
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="username" class="block text-sm font-medium text-[#03045e]">Customer Name</label>
                        <input type="text" name="username" id="username" required
                               class="mt-1 block w-full border-2 border-[#90e0ef] rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#00b4d8] focus:border-[#00b4d8] transition duration-300">
                    </div>
                    <div>
                        <label for="product_id" class="block text-sm font-medium text-[#03045e]">Select Product</label>
                        <select name="product_id" id="product_id" required
                                class="mt-1 block w-full border-2 border-[#90e0ef] rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#00b4d8] focus:border-[#00b4d8] transition duration-300">
                            <option value="" data-price="">Select a product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                    {{ $product->product_Name }} - ${{ $product->price }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="quantity" class="block text-sm font-medium text-[#03045e]">Quantity</label>
                        <input type="number" name="quantity" id="quantity" required min="1"
                               class="mt-1 block w-full border-2 border-[#90e0ef] rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#00b4d8] focus:border-[#00b4d8] transition duration-300">
                    </div>
                    <div>
                        <label for="price" class="block text-sm font-medium text-[#03045e]">Total Price</label>
                        <input type="number" name="price" id="price" readonly required
                               class="mt-1 block w-full bg-[#f0f9ff] border-2 border-[#90e0ef] rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#00b4d8] focus:border-[#00b4d8] transition duration-300">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="purchase_date" class="block text-sm font-medium text-[#03045e]">Purchase Date and Time</label>
                        <input type="text" name="purchase_date" id="purchase_date" required
                               class="mt-1 block w-full border-2 border-[#90e0ef] rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-[#00b4d8] focus:border-[#00b4d8] transition duration-300 flatpickr">
                    </div>
                </div>
                <div>
                    <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#00b4d8] hover:bg-[#0077b6] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#00b4d8] transition duration-300">
                        Complete Purchase
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    function updatePrice() {
        const selectedOption = document.getElementById('product_id').options[document.getElementById('product_id').selectedIndex];
        const pricePerUnit = parseFloat(selectedOption.getAttribute('data-price'));
        const quantity = parseInt(document.getElementById('quantity').value);

        if (!isNaN(pricePerUnit) && !isNaN(quantity)) {
            const totalPrice = pricePerUnit * quantity;
            document.getElementById('price').value = totalPrice.toFixed(2);
        } else {
            document.getElementById('price').value = '';
        }
    }

    document.getElementById('product_id').addEventListener('change', updatePrice);
    document.getElementById('quantity').addEventListener('input', updatePrice);

    flatpickr("#purchase_date", {
        enableTime: true,
        dateFormat: "F j, Y H:i",
        theme: "airbnb"
    });
</script>
@endsection
