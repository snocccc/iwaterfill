@extends('components.layoutDash')

@section('dash')
<div class="bg-gray-100 flex justify-center items-center min-h-screen py-4 px-2">

    <div class="w-full max-w-6xl bg-white shadow-md rounded-lg p-4 md:p-8">
        <h2 class="text-2xl font-semibold text-center mb-6">Sales Overview</h2>

        <!-- Total Sales Section -->
        <div class="mb-4 flex justify-between">
            <div class="p-4 bg-green-100 text-green-700 rounded-lg shadow-md text-center flex-1 mx-2">
                <h3 class="text-lg font-semibold">Total Sales Today</h3>
                <p class="text-2xl">${{ number_format($totalSalesToday, 2) }}</p>
            </div>
            <div class="p-4 bg-blue-100 text-blue-700 rounded-lg shadow-md text-center flex-1 mx-2">
                <h3 class="text-lg font-semibold">Total Sales</h3>
                <p class="text-2xl">${{ number_format($totalSales, 2) }}</p>
            </div>
        </div>

        <!-- Period Select -->
        <div class="mb-4 flex justify-center">
            <form action="{{ route('dashboard') }}" method="GET" class="flex items-center">
                <label for="period" class="mr-2 text-gray-700 font-medium">Select Period:</label>
                <select id="period" name="period" class="p-2 border border-gray-300 rounded-lg" onchange="this.form.submit()">
                    <option value="weekly" {{ $period == 'weekly' ? 'selected' : '' }}>Weekly</option>
                    <option value="monthly" {{ $period == 'monthly' ? 'selected' : '' }}>Monthly</option>
                    <option value="yearly" {{ $period == 'yearly' ? 'selected' : '' }}>Yearly</option>
                </select>
            </form>
        </div>

        <!-- Chart.js Canvas -->
        <canvas id="salesChart" class="w-full h-64"></canvas>

        <!-- Chart Script -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const salesData = @json($salesData);
            const totals = salesData.map(data => data.total_sales);
            const dates = salesData.map(data => data.date); // Get the dates from sales data

            // Define labels based on the selected period
            let labels = [];
            const currentYear = new Date().getFullYear();

            if ("{{ $period }}" === "weekly") {
                labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
            } else if ("{{ $period }}" === "monthly") {
                labels = Array.from({ length: 12 }, (v, i) => {
                    const month = new Date(0, i).toLocaleString('default', { month: 'short' });
                    return `${month} ${currentYear}`;
                }).filter((_, index) => totals[index] !== undefined); // Filter to only include months with data
            } else if ("{{ $period }}" === "yearly") {
                labels = Array.from({ length: currentYear - 2021 + 1 }, (v, i) => 2021 + i);
            }

            const ctx = document.getElementById('salesChart').getContext('2d');
            const salesChart = new Chart(ctx, {
                type: 'line', // Type of chart (e.g., line, bar, pie)
                data: {
                    labels: dates.length ? dates : ['No Data'], // Use actual data or a default value
                    datasets: [{
                        label: 'Total Sales',
                        data: totals.length ? totals : [0], // Use actual data or a default value
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 1,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Period' // Title for the x-axis
                            }
                        }
                    }
                }
            });
        </script>
    </div>
</div>
@endsection
