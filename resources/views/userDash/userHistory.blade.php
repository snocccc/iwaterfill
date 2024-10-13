@extends('components.layoutUser')

@section('userDash')
<div class="bg-[#caf0f8] min-h-screen py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-[#03045e] mb-6">Payment History</h1>

        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-[#0077b6] text-white">
                            <th class="py-4 px-6 text-left font-semibold">Product Name</th>
                            <th class="py-4 px-6 text-left font-semibold">Customer Name</th>
                            <th class="py-4 px-6 text-left font-semibold">Price</th>
                            <th class="py-4 px-6 text-left font-semibold">Purchase Date</th>
                            <th class="py-4 px-6 text-left font-semibold">Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                        <tr class="border-b border-[#90e0ef] hover:bg-[#e6f8fc] transition duration-300">
                            <td class="py-4 px-6">{{ $payment->product_Name }}</td>
                            <td class="py-4 px-6">{{ $payment->username }}</td>
                            <td class="py-4 px-6 font-medium text-[#03045e]">₱{{ number_format($payment->price, 2) }}</td>
                            <td class="py-4 px-6">{{ \Carbon\Carbon::parse($payment->purchase_date)->format('F d, Y') }}</td>
                            <td class="py-4 px-6">{{ $payment->quantity }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
