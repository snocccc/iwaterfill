@extends('components.layoutDash')

@section('dash')

<body class="bg-gray-100 flex justify-center items-center h-screen">

    <div class="w-full max-w-md bg-white shadow-md rounded-lg p-8">
        <h2 class="text-2xl font-semibold text-center mb-6">Purchase Product</h2>

        <form action="{{ route('payment') }}" method="POST">
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
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->product_Name }} - ${{ $product->price }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Price -->
            <div class="mb-4">
                <label for="price" class="block text-gray-700 font-medium mb-2">Price</label>
                <input type="number" name="price" id="price" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
            </div>

            <!-- Date and Time -->
            <div class="mb-4">
                <label for="purchase_date" class="block text-gray-700 font-medium mb-2">Date and Time</label>
                <input type="datetime-local" name="purchase_date" id="purchase_date" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" required>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="w-full bg-blue-500 text-white p-3 rounded-lg hover:bg-blue-600 transition duration-300">Submit Purchase</button>
            </div>

        </form>
    </div>

</body>

@endsection
