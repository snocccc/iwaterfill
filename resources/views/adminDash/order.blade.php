@extends('components.layoutDash')

@section('dash')
<div class="bg-[#CAF0F8] min-h-screen py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-[#03045E]">Pending Orders</h1>
            <button class="bg-[#00B4D8] text-white px-4 py-2 rounded-lg hover:bg-[#0077B6] transition duration-300 ease-in-out shadow-md">
                Success Orders
            </button>
        </div>

        @if(session('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-md">
            {{ session('message') }}
        </div>
        @endif

        @if($orders->isEmpty())
            <p class="text-center text-[#03045E] text-lg">No pending orders at the moment.</p>
        @else
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <table class="min-w-full divide-y divide-[#90E0EF]">
                    <thead class="bg-[#0077B6]">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Order #</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Username</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Product</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-[#90E0EF]">
                        @foreach($orders as $order)
                            <tr class="hover:bg-[#CAF0F8] transition duration-300 ease-in-out">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[#03045E]">{{ $order->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[#03045E]">{{ $order->username }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[#03045E]">{{ $order->product_Name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <button
                                        class="bg-[#00B4D8] text-white px-4 py-2 rounded-lg hover:bg-[#0077B6] transition duration-300 ease-in-out shadow-md"
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
        <div id="orderModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
            <div class="bg-white w-11/12 sm:w-2/3 md:w-1/2 lg:w-1/3 rounded-lg shadow-2xl p-6">
                <h2 class="text-2xl font-bold mb-6 text-[#03045E]">Order Details</h2>
                <form method="POST" action="{{ route('placeOrder') }}">
                    @csrf
                    <input type="hidden" name="order_id" id="modalOrderId">

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-[#0077B6]">Username:</label>
                            <p id="modalUsername" class="text-lg font-semibold text-[#03045E]"></p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[#0077B6]">Product:</label>
                            <p id="modalProduct" class="text-lg font-semibold text-[#03045E]"></p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[#0077B6]">Quantity:</label>
                            <p id="modalQuantity" class="text-lg font-semibold text-[#03045E]"></p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[#0077B6]">Price:</label>
                            <p id="modalPrice" class="text-lg font-semibold text-[#03045E]"></p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-[#0077B6]">Date:</label>
                            <p id="modalDate" class="text-lg font-semibold text-[#03045E]"></p>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end space-x-4">
                        <button type="submit" class="bg-[#00B4D8] text-white px-6 py-2 rounded-lg hover:bg-[#0077B6] transition duration-300 ease-in-out shadow-md">
                            Place Order
                        </button>
                        <button type="button" onclick="closeModal()" class="bg-[#03045E] text-white px-6 py-2 rounded-lg hover:bg-[#0077B6] transition duration-300 ease-in-out shadow-md">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openModal(orderId) {
        const order = @json($orders).find(o => o.id === orderId);
        document.getElementById('modalOrderId').value = order.id;
        document.getElementById('modalUsername').textContent = order.username;
        document.getElementById('modalProduct').textContent = order.product_Name;
        document.getElementById('modalQuantity').textContent = order.quantity;
        document.getElementById('modalPrice').textContent = order.price;
        document.getElementById('modalDate').textContent = order.purchase_date;
        document.getElementById('orderModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('orderModal').classList.add('hidden');
    }
</script>
@endsection
