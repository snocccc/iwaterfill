@extends('components.layoutDash')

@section('dash')
<div class="bg-[#caf0f8] min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-3xl font-bold text-center mb-10 text-[#03045e]">Sales Overview</h2>

        <!-- Total Sales Section -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-10">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-[#0077b6] mb-2">Total Sales Today</h3>
                <p class="text-3xl font-bold text-[#03045e]">₱{{ number_format($totalSalesToday, 2) }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-[#0077b6] mb-2">Total Sales</h3>
                <p class="text-3xl font-bold text-[#03045e]">₱{{ number_format($totalSales, 2) }}</p>
            </div>
        </div>

        <!-- Period Select -->
        <div class="mb-8 flex justify-center">
            <form action="{{ route('dashboard') }}" method="GET" class="flex items-center">
                <label for="period" class="mr-3 text-[#03045e] font-medium">View Sales:</label>
                <select id="period" name="period" class="p-2 border border-[#90e0ef] rounded-lg bg-white text-[#03045e] focus:outline-none focus:ring-2 focus:ring-[#00b4d8]" onchange="this.form.submit()">
                    <option value="weekly" {{ $period == 'weekly' ? 'selected' : '' }}>Weekly</option>
                    <option value="monthly" {{ $period == 'monthly' ? 'selected' : '' }}>Monthly</option>
                    <option value="yearly" {{ $period == 'yearly' ? 'selected' : '' }}>Yearly</option>
                </select>
            </form>
        </div>

        <!-- Chart.js Canvas -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <canvas id="salesChart" class="w-full" style="height: 300px;"></canvas>
        </div>
    </div>
</div>

<!-- Chart Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const salesData = @json($salesData);
    const totals = salesData.map(data => data.total_sales);
    const dates = salesData.map(data => data.date);

    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: dates.length ? dates : ['No Data'],
            datasets: [{
                label: 'Total Sales',
                data: totals.length ? totals : [0],
                borderColor: '#0077b6',
                backgroundColor: 'rgba(0, 180, 216, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value, index, values) {
                            return '₱' + value.toLocaleString();
                        }
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: '{{ ucfirst($period) }} Period'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return '₱' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
