@extends('components.layoutUser')

@section('userDash')
<div class="bg-[#caf0f8] min-h-screen py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl md:text-4xl font-bold text-[#03045e] mb-6">Order History</h1>

        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
            <!-- Table for larger screens -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-[#0077b6] text-white">
                            <th class="py-2 px-4 text-left font-semibold text-sm md:text-base">Product Name</th>
                            <th class="py-2 px-4 text-left font-semibold text-sm md:text-base">Customer Name</th>
                            <th class="py-2 px-4 text-left font-semibold text-sm md:text-base">Price</th>
                            <th class="py-2 px-4 text-left font-semibold text-sm md:text-base">Purchase Date</th>
                            <th class="py-2 px-4 text-left font-semibold text-sm md:text-base">Quantity</th>
                            <th class="py-2 px-4 text-left font-semibold text-sm md:text-base">Status</th> <!-- New Status Column -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr class="border-b border-[#90e0ef] hover:bg-[#e6f8fc] transition duration-300">
                            <td class="py-2 px-4 text-sm md:text-base">{{ $order->product_Name }}</td>
                            <td class="py-2 px-4 text-sm md:text-base">{{ $order->username }}</td>
                            <td class="py-2 px-4 text-sm md:text-base font-medium text-[#03045e]">₱{{ number_format($order->price, 2) }}</td>
                            <td class="py-2 px-4 text-sm md:text-base">{{ \Carbon\Carbon::parse($order->purchase_date)->format('F d, Y') }}</td>
                            <td class="py-2 px-4 text-sm md:text-base">{{ $order->quantity }}</td>
                            <td class="py-2 px-4 text-sm md:text-base">{{ $order->status ? 'Done' : 'Processing' }}</td> <!-- Display Status -->
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Card view for mobile screens -->
            <div class="block md:hidden">
                @foreach($orders as $order)
                <div class="bg-white rounded-lg shadow-md p-4 mb-4">
                    <h2 class="font-bold text-[#03045e]">{{ $order->product_Name }}</h2>
                    <p>Customer: {{ $order->username }}</p>
                    <p>Price: <span class="font-medium text-[#03045e]">₱{{ number_format($order->price, 2) }}</span></p>
                    <p>Purchase Date: {{ \Carbon\Carbon::parse($order->purchase_date)->format('F d, Y') }}</p>
                    <p>Quantity: {{ $order->quantity }}</p>
                    <p>Status: <span class="{{ $order->status ? 'text-green-500' : 'text-yellow-500' }}">{{ $order->status ? 'Done' : 'Processing' }}</span></p> <!-- Display Status -->
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
