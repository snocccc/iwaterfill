@extends('components.layoutDash')

@section('dash')
<div class="bg-[#caf0f8] min-h-screen py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-[#03045e] mb-6">Purchase History</h1>

        <!-- Date Filter -->
        <div class="mb-4 flex flex-col md:flex-row justify-center items-center">
            <label for="filter_date" class="mr-2 text-[#03045e] font-medium mb-2 md:mb-0">Filter by Date:</label>
            <form action="{{ route('history') }}" method="GET" class="flex items-center">
                <input type="date" id="filter_date" name="date" class="p-2 border-2 border-[#90e0ef] rounded-lg bg-[#f0f9ff]" value="{{ request('date') }}">
                <button type="submit" class="ml-2 bg-[#00b4d8] text-white px-4 py-2 rounded-lg hover:bg-[#0077b6] transition duration-300">Filter</button>
            </form>
            <form action="{{ route('history') }}" method="GET" class="ml-4">
                <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Show All</button>
            </form>
        </div>

        <!-- Purchase Table -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-[#0077b6] text-white">
                        <th class="border border-[#90e0ef] p-3">Customer Name</th>
                        <th class="border border-[#90e0ef] p-3">Product Name</th>
                        <th class="border border-[#90e0ef] p-3">Price</th>
                        <th class="border border-[#90e0ef] p-3">Purchase Date</th>
                        <th class="border border-[#90e0ef] p-3">Actions</th> <!-- Column for Actions -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                        <tr class="border-b border-[#90e0ef] hover:bg-[#e6f8fc] transition duration-300">
                            <td class="border border-[#90e0ef] p-3">{{ $payment->username }}</td>
                            <td class="border border-[#90e0ef] p-3">{{ $payment->product_Name }}</td>
                            <td class="border border-[#90e0ef] p-3 font-medium text-[#03045e]">₱{{ number_format($payment->price, 2) }}</td>
                            <td class="border border-[#90e0ef] p-3">{{ \Carbon\Carbon::parse($payment->purchase_date)->format('F d, Y') }}</td>
                            <td class="border border-[#90e0ef] p-3">
                                <!-- Edit Button -->
                                <a href="{{ route('payments.edit', $payment->id) }}" class="text-[#0077b6] hover:underline">Edit</a>

                                <!-- Delete Button -->
                                <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline ml-4" onclick="return confirm('Are you sure you want to delete this record?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add DataTables script -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#purchaseTable').DataTable();

            // Handle the table update if you want to filter directly in the frontend
            $('#filter_date').on('change', function() {
                var selectedDate = $(this).val();

                table.rows().every(function() {
                    var row = $(this.node());
                    var rowDate = row.find('td:nth-child(4)').text().split(' ')[0]; // Extract date from the purchase date column

                    if (selectedDate === '' || rowDate === selectedDate) {
                        row.show();
                    } else {
                        row.hide();
                    }
                });
            });
        });
    </script>
@endsection
