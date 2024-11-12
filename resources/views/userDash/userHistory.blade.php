@extends('components.layoutUser')

@section('userDash')
<div class="bg-gradient-to-br from-blue-50 to-cyan-50 min-h-screen py-8">
    <div class="container mx-auto px-4">
        <div class="flex items-center gap-2 mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#03045e]">
                <path d="M3 7V5c0-1.1.9-2 2-2h2"></path>
                <path d="M17 3h2c1.1 0 2 .9 2 2v2"></path>
                <path d="M21 17v2c0 1.1-.9 2-2 2h-2"></path>
                <path d="M7 21H5c-1.1 0-2-.9-2-2v-2"></path>
                <rect width="7" height="5" x="7" y="7" rx="1"></rect>
                <rect width="7" height="5" x="10" y="12" rx="1"></rect>
            </svg>
            <h1 class="text-3xl md:text-4xl font-bold text-[#03045e]">Order History</h1>
        </div>

        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
            <!-- Table for larger screens -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-[#0077b6] text-white">
                            <th class="py-3 px-4 text-left font-semibold text-sm md:text-base">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m20.9 18.55-8-15.98a1 1 0 0 0-1.8 0l-8 15.98a1 1 0 0 0 .9 1.45h16a1 1 0 0 0 .9-1.45"></path>
                                    </svg>
                                    Product Name
                                </div>
                            </th>
                            <th class="py-3 px-4 text-left font-semibold text-sm md:text-base">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="12" cy="7" r="4"></circle>
                                    </svg>
                                    Customer Name
                                </div>
                            </th>
                            <th class="py-3 px-4 text-left font-semibold text-sm md:text-base">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="8"></circle>
                                        <path d="M10 13.2A1 1 0 0 1 11 12v-1a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1h-1a1 1 0 0 0-1 1v1"></path>
                                        <path d="M12 16h.01"></path>
                                    </svg>
                                    Price
                                </div>
                            </th>
                            <th class="py-3 px-4 text-left font-semibold text-sm md:text-base">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    Purchase Date
                                </div>
                            </th>
                            <th class="py-3 px-4 text-left font-semibold text-sm md:text-base">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                        <line x1="3" y1="6" x2="21" y2="6"></line>
                                        <path d="M16 10a4 4 0 0 1-8 0"></path>
                                    </svg>
                                    Quantity
                                </div>
                            </th>
                            <th class="py-3 px-4 text-left font-semibold text-sm md:text-base">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 7h-9"></path>
                                        <path d="M14 17H5"></path>
                                        <circle cx="17" cy="17" r="3"></circle>
                                        <circle cx="7" cy="7" r="3"></circle>
                                    </svg>
                                    Status
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr class="border-b border-[#90e0ef] hover:bg-[#e6f8fc] transition duration-300">
                            <td class="py-3 px-4 text-sm md:text-base">{{ $order->product_Name }}</td>
                            <td class="py-3 px-4 text-sm md:text-base">{{ $order->username }}</td>
                            <td class="py-3 px-4 text-sm md:text-base font-medium text-[#03045e]">₱{{ number_format($order->price, 2) }}</td>
                            <td class="py-3 px-4 text-sm md:text-base">{{ \Carbon\Carbon::parse($order->purchase_date)->format('F d, Y') }}</td>
                            <td class="py-3 px-4 text-sm md:text-base">{{ $order->quantity }}</td>
                            <td class="py-3 px-4 text-sm md:text-base">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->status ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        @if($order->status)
                                            <path d="M20 6 9 17l-5-5"></path>
                                        @else
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="12" y1="8" x2="12" y2="12"></line>
                                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                        @endif
                                    </svg>
                                    {{ $order->status ? 'Done' : 'Processing' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Card view for mobile screens -->
            <div class="block md:hidden">
                @foreach($orders as $order)
                <div class="bg-white rounded-lg shadow-md p-4 mb-4">
                    <div class="flex items-center gap-2 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#03045e]">
                            <path d="m20.9 18.55-8-15.98a1 1 0 0 0-1.8 0l-8 15.98a1 1 0 0 0 .9 1.45h16a1 1 0 0 0 .9-1.45"></path>
                        </svg>
                        <h2 class="font-bold text-[#03045e]">{{ $order->product_Name }}</h2>
                    </div>
                    <div class="space-y-2">
                        <p class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            Customer: {{ $order->username }}
                        </p>
                        <p class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="8"></circle>
                                <path d="M10 13.2A1 1 0 0 1 11 12v-1a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1h-1a1 1 0 0 0-1 1v1"></path>
                                <path d="M12 16h.01"></path>
                            </svg>
                            Price: <span class="font-medium text-[#03045e]">₱{{ number_format($order->price, 2) }}</span>
                        </p>
                        <p class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            Purchase Date: {{ \Carbon\Carbon::parse($order->purchase_date)->format('F d, Y') }}
                        </p>
                        <p class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <path d="M16 10a4 4 0 0 1-8 0"></path>
                            </svg>
                            Quantity: {{ $order->quantity }}
                        </p>
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 7h-9"></path>
                                <path d="M14 17H5"></path>
                                <circle cx="17" cy="17" r="3"></circle>
                                <circle cx="7" cy="7" r="3"></circle>
                            </svg>
                            Status:
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->status ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    @if($order->status)
                                        <path d="M20 6 9 17l-5-5"></path>
                                    @else
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="12" y1="8" x2="12" y2="12"></line>
                                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                    @endif
                                </svg>
                                {{ $order->status ? 'Done' : 'Processing' }}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
