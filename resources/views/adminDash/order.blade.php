@extends('components.layoutDash')
@section('title', 'Pending Orders')
@section('dash')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-cyan-50">
    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <h1 class="text-2xl font-semibold text-gray-900 mb-4 sm:mb-0 flex items-center">
                    <svg class="h-8 w-8 text-indigo-600 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Pending Orders
                </h1>
                <a href="{{ route('completed.orders') }}">
                    <button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Completed Orders
                    </button>
                </a>
            </div>

            <!-- Alert Message -->
            @if(session('message'))
            <div class="mb-6 border-l-4 border-green-500 bg-green-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('message') }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Orders Section -->
            @if($orders->isEmpty())
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="mt-4 text-gray-500 text-lg">No pending orders at the moment</p>
                </div>
            @else
                <!-- Desktop View (md and up) -->
                <div class="hidden md:block">
                    <div class="bg-white rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($orders as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $order->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->username }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->product_Name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->quantity }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->price }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->location }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->phone }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <button onclick="openModal({{ $order->id }})" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Process
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Mobile View (less than md) -->
                <div class="md:hidden space-y-4">
                    @foreach($orders as $order)
                    <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-sm font-medium text-gray-900">Order #{{ $order->id }}</span>
                            <button onclick="openModal({{ $order->id }})" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Process
                            </button>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Username:</span>
                                <span class="text-sm text-gray-900 my-4">{{ $order->username }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Product:</span>
                                <span class="text-sm text-gray-900">{{ $order->product_Name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Location:</span>
                                <span class="text-sm text-gray-900">{{ $order->product_Name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Quantity:</span>
                                <span class="text-sm text-gray-900">{{ $order->quantity }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Price:</span>
                                <span class="text-sm text-gray-900">{{ $order->price }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Location:</span>
                                <span class="text-sm text-gray-900">{{ $order->location }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-500">Phone:</span>
                                <span class="text-sm text-gray-900">{{ $order->phone }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif

           <!-- Modal -->
<div id="orderModal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 overflow-y-auto h-full w-full" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="relative inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <div class="absolute top-0 right-0 pt-4 pr-4">
                <button onclick="closeModal()" type="button" class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <span class="sr-only">Close</span>
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="sm:flex sm:items-start">
                <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6 flex items-center" id="modal-title">
                        <svg class="h-6 w-6 text-indigo-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Order Details
                    </h3>

                    @if($orders->isEmpty())
    <p>There's No Pending Orders Yet.</p>
@else

                    <!-- Display Product Image -->
                    <img id="modalProductImage" src="{{ asset('images/' . $order->image_url . '.png') }}" alt="Product Image" class="w-[300px] h-[300px] mb-4 ml-10">
                    @endif
                    <form method="POST" action="{{ route('placeOrder') }}" class="space-y-6">
                        @csrf
                        <input type="hidden" name="order_id" id="modalOrderId">

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 flex items-center">
                                    <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Username
                                </label>
                                <p id="modalUsername" class="mt-1 text-sm text-gray-900"></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 flex items-center">
                                    <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                    Product
                                </label>
                                <p id="modalProduct" class="mt-1 text-sm text-gray-900"></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 flex items-center">
                                    <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    Quantity
                                </label>
                                <p id="modalQuantity" class="mt-1 text-sm text-gray-900"></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 flex items-center">
                                    <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2 .895 2 2 0 1.105-.89 2-2 2s-2-.895-2-2 0-2 2-2"/>
                                    </svg>
                                    Price
                                </label>
                                <p id="modalPrice" class="mt-1 text-sm text-gray-900"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 flex items-center">
                                    <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2 .895 2 2 0 1.105-.89 2-2 2s-2-.895-2-2 0-2 2-2"/>
                                    </svg>
                                    Location
                                </label>
                                <p id="modalLocation" class="mt-1 text-sm text-gray-900"></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 flex items-center">
                                    <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2 .895 2 2 0 1.105-.89 2-2 2s-2-.895-2-2 0-2 2-2"/>
                                    </svg>
                                    Phone
                                </label>
                                <p id="modalPhone" class="mt-1 text-sm text-gray-900"></p>
                            </div>
                        </div>

                        <button type="submit" class="inline-flex justify-center w-full rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Order Delivered
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

        </div>
    </div>
</div>

<script>
   function openModal(orderId) {
    const order = @json($orders).find(order => order.id === orderId);

    // Populate modal fields
    document.getElementById('modalProductImage').src = `/images/${order.image_url}.png`; // Adjust the path if necessary
    document.getElementById('modalOrderId').value = order.id;
    document.getElementById('modalUsername').textContent = order.username;
    document.getElementById('modalProduct').textContent = order.product_Name;
    document.getElementById('modalQuantity').textContent = order.quantity;
    document.getElementById('modalPrice').textContent = order.price;
    document.getElementById('modalLocation').textContent = order.location;
    document.getElementById('modalPhone').textContent = order.phone;

    // Show modal
    document.getElementById('orderModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('orderModal').classList.add('hidden');
}

</script>
@endsection
