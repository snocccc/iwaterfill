@extends('components.layoutDash')

@section('dash')
<div class="container mx-auto mt-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Pending Orders</h1>
        <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            Success Orders
        </button>
    </div>

    @if(session('message'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
        {{ session('message') }}
    </div>
@endif

    @if($orders->isEmpty())
        <p class="text-center text-gray-500">Walang pending orders.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="py-3 px-6 border border-gray-300 text-left">Order #</th>
                        <th class="py-3 px-6 border border-gray-300 text-left">Username</th>
                        <th class="py-3 px-6 border border-gray-300 text-left">Product</th>
                        <th class="py-3 px-6 border border-gray-300 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="hover:bg-gray-100">
                            <td class="py-3 px-6 border border-gray-300">{{ $order->id }}</td>
                            <td class="py-3 px-6 border border-gray-300">{{ $order->username }}</td>
                            <td class="py-3 px-6 border border-gray-300">{{ $order->product_Name }}</td>
                            <td class="py-3 px-6 border border-gray-300 text-center">
                                <button
                                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                                    onclick="openModal({{ $order->id }})"
                                >
                                    Process
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <!-- Modal -->
    <div id="orderModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white w-1/2 rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold mb-4">Order Details</h2>
            <form method="POST" action="{{ route('placeOrder') }}">
                @csrf
                <input type="hidden" name="order_id" id="modalOrderId">

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Username:</label>
                    <p id="modalUsername" class="text-lg font-semibold"></p>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Product:</label>
                    <p id="modalProduct" class="text-lg font-semibold"></p>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Quantity:</label>
                    <p id="modalQuantity" class="text-lg font-semibold"></p>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Price:</label>
                    <p id="modalPrice" class="text-lg font-semibold"></p>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Date:</label>
                    <p id="modalDate" class="text-lg font-semibold"></p>
                </div>


                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    Place Order
                </button>
                <button type="button" onclick="closeModal()" class="ml-2 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                    Cancel
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Function to open the modal and fill in the order details
    function openModal(orderId) {
        // Retrieve the order details from Laravel collection
        const order = @json($orders).find(o => o.id === orderId);

        // Populate modal fields with order data
        document.getElementById('modalOrderId').value = order.id;
        document.getElementById('modalUsername').textContent = order.username;
        document.getElementById('modalProduct').textContent = order.product_Name;
        document.getElementById('modalQuantity').textContent = order.quantity;
        document.getElementById('modalPrice').textContent = order.price;
        document.getElementById('modalDate').textContent = order.purchase_date;

        // Show the modal
        document.getElementById('orderModal').classList.remove('hidden');
    }

    // Function to close the modal
    function closeModal() {
        document.getElementById('orderModal').classList.add('hidden');
    }
</script>
@endsection
