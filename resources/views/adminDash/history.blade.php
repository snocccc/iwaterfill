@extends('components.layoutDash')
@section('title', 'Transaction History')
@section('dash')
<div class="bg-gradient-to-br from-blue-50 to-cyan-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8 flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-900">
                <path d="M3 3v18h18"/>
                <path d="m19 9-5 5-4-4-3 3"/>
            </svg>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Purchase History</h1>
                <p class="mt-2 text-sm text-gray-600">Manage and track all purchase transactions</p>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="mb-8 bg-gray-50 rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end">
                <div>
                    <label for="filter_date" class="block text-sm font-medium text-gray-700 mb-2 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                            <line x1="16" x2="16" y1="2" y2="6"/>
                            <line x1="8" x2="8" y1="2" y2="6"/>
                            <line x1="3" x2="21" y1="10" y2="10"/>
                        </svg>
                        Filter by Date
                    </label>
                    <form action="{{ route('history') }}" method="GET" class="flex gap-3">
                        <input
                            type="date"
                            id="filter_date"
                            name="date"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            value="{{ request('date') }}"
                        >
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Apply Filter
                        </button>
                    </form>
                </div>
                <div class="flex justify-start md:justify-end">
                    <form action="{{ route('history') }}" method="GET">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Reset Filters
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table Type Selector -->
        <div class="mb-6">
            <div class="relative">
                <select
                    onchange="toggleTableView(this.value)"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    <option value="pos">By POS</option>
                    <option value="online">By Online</option>
                </select>
            </div>
        </div>

        <!-- POS Transactions Table -->
        <div id="posTable" class="bg-white shadow-sm rounded-lg overflow-hidden">
            <!-- Desktop View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purchase Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($payments as $payment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $payment->username }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $payment->product_Name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{$payment->quantity}}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₱{{ number_format($payment->price, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($payment->purchase_date)->format('F d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile View for POS -->
            <div class="md:hidden">
                <div class="grid grid-cols-1 gap-4 p-4">
                    @foreach($payments as $payment)
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-4">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">{{ $payment->product_Name }}</h3>
                                <p class="text-sm text-gray-500">{{ $payment->username }}</p>
                            </div>
                            <p class="text-lg font-semibold text-gray-900">₱{{ number_format($payment->price, 2) }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-sm text-gray-500">Quantity</p>
                                <p class="text-sm font-medium text-gray-900">{{$payment->quantity}}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Purchase Date</p>
                                <p class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($payment->purchase_date)->format('F d, Y') }}</p>
                            </div>
                        </div>

                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Online Orders Table -->
        <div id="onlineTable" class="bg-white shadow-sm rounded-lg overflow-hidden hidden">
            <!-- Desktop View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purchase Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->username }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->product_Name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->quantity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₱{{ number_format($order->price, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->location }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($order->purchase_date)->format('F d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile View for Online Orders -->
            <div class="md:hidden">
                <div class="grid grid-cols-1 gap-4 p-4">
                    @foreach($orders as $order)
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-4">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">{{ $order->product_Name }}</h3>
                                <p class="text-sm text-gray-500">{{ $order->username }}</p>
                            </div>
                            <p class="text-lg font-semibold text-gray-900">₱{{ number_format($order->price, 2) }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-sm text-gray-500">Quantity</p>
                                <p class="text-sm font-medium text-gray-900">{{ $order->quantity }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Location</p>
                                <p class="text-sm font-medium text-gray-900">{{ $order->location }}</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-sm text-gray-500">Purchase Date</p>
                                <p class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($order->purchase_date)->format('F d, Y') }}</p>
                            </div>
                        </div>

                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
</div>

<script>
function toggleTableView(value) {
const posTable = document.getElementById('posTable');
const onlineTable = document.getElementById('onlineTable');

if (value === 'pos') {
    posTable.classList.remove('hidden');
    onlineTable.classList.add('hidden');
} else {
    posTable.classList.add('hidden');
    onlineTable.classList.remove('hidden');
}
}

// Initialize the view based on the select value when the page loads
document.addEventListener('DOMContentLoaded', function() {
const selectElement = document.querySelector('select');
toggleTableView(selectElement.value);
});
</script>
@endsection
