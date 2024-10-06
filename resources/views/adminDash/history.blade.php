@extends('components.layoutDash')

@section('dash')
<div class="bg-gray-100 flex justify-center items-center min-h-screen py-4 px-2">

    <div class="w-full max-w-6xl bg-white shadow-md rounded-lg p-4 md:p-8">
        <h2 class="text-2xl font-semibold text-center mb-6">Purchase History</h2>

        <!-- Date Filter -->
        <div class="mb-4 flex flex-col md:flex-row justify-center items-center">
            <label for="filter_date" class="mr-2 text-gray-700 font-medium mb-2 md:mb-0">Filter by Date:</label>
            <form action="{{ route('history') }}" method="GET" class="flex items-center">
                <input type="date" id="filter_date" name="date" class="p-2 border border-gray-300 rounded-lg" value="{{ request('date') }}">
                <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Filter</button>
            </form>
            <form action="{{ route('history') }}" method="GET" class="ml-4">
                <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Show All</button>
            </form>
        </div>

        <!-- Purchase Table -->
        <div class="overflow-x-auto">
            <table id="purchaseTable" class="w-full border-collapse border border-gray-200">
                <thead>
                    <tr>
                        <th class="border border-gray-300 p-3">Customer Name</th>
                        <th class="border border-gray-300 p-3">Product Name</th>
                        <th class="border border-gray-300 p-3">Price</th>
                        <th class="border border-gray-300 p-3">Purchase Date</th>
                        <th class="border border-gray-300 p-3">Actions</th> <!-- Column for Actions -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                        <tr>
                            <td class="border border-gray-300 p-3">{{ $payment->customer_Name }}</td>
                            <td class="border border-gray-300 p-3">{{ $payment->product_Name }}</td>
                            <td class="border border-gray-300 p-3">${{ $payment->price }}</td>
                            <td class="border border-gray-300 p-3">{{ $payment->purchase_date->format('Y-m-d H:i') }}</td>
                            <td class="border border-gray-300 p-3">
                                <!-- Edit Button -->
                                <a href="{{ route('payments.edit', $payment->id) }}" class="text-blue-500 hover:underline">Edit</a>

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
                    var rowDate = row.find('td:last-child').text().split(' ')[0]; // Extract date from the purchase date column

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
