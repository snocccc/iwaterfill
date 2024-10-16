@extends('components.layoutDash')

@section('dash')
<div class="bg-gradient-to-br from-[#caf0f8] to-[#90e0ef] min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-4xl font-extrabold text-center mb-12 text-[#03045e]">Sales Dashboard</h2>

        <!-- Total Sales Section -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 mb-12">
            <div class="bg-white p-8 rounded-2xl shadow-lg transition-transform hover:scale-105">
                <h3 class="text-xl font-semibold text-[#0077b6] mb-3">Total Sales Today</h3>
                <p class="text-4xl font-bold text-[#03045e]">₱{{ number_format($totalSalesToday, 2) }}</p>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-lg transition-transform hover:scale-105">
                <h3 class="text-xl font-semibold text-[#0077b6] mb-3">Total Sales</h3>
                <p class="text-4xl font-bold text-[#03045e]">₱{{ number_format($totalSales, 2) }}</p>
            </div>
        </div>

        <!-- Period Select -->
        <div class="mb-10 flex justify-center">
            <form action="{{ route('dashboard') }}" method="GET" class="flex items-center bg-white p-2 rounded-full shadow-md">
                <label for="period" class="mr-3 text-[#03045e] font-medium">View Sales:</label>
                <select id="period" name="period" class="p-2 border-none rounded-full bg-[#e6f9ff] text-[#03045e] focus:outline-none focus:ring-2 focus:ring-[#00b4d8] transition-colors" onchange="this.form.submit()">
                    <option value="weekly" {{ $period == 'weekly' ? 'selected' : '' }}>Weekly</option>
                    <option value="monthly" {{ $period == 'monthly' ? 'selected' : '' }}>Monthly</option>
                    <option value="yearly" {{ $period == 'yearly' ? 'selected' : '' }}>Yearly</option>
                </select>
            </form>
        </div>

        <!-- Chart.js Canvas -->
        <div class="bg-white p-8 rounded-2xl shadow-lg">
            <canvas id="salesChart" class="w-full" style="height: 400px;"></canvas>
        </div>
    </div>
</div>

<!-- Chart Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
<script>
    const salesData = @json($salesData);
    const totals = salesData.map(data => data.total_sales);
    const dates = salesData.map(data => data.date);
    const period = '{{ $period }}';

    const formatDate = (date) => {
        const momentDate = moment(date);
        switch(period) {
            case 'weekly':
                return momentDate.format('ddd');
            case 'monthly':
                return momentDate.format('MMM D');
            case 'yearly':
                return momentDate.format('MMM YYYY');
            default:
                return date;
        }
    };

    const formattedDates = dates.map(formatDate);

    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: formattedDates.length ? formattedDates : ['No Data'],
            datasets: [{
                label: 'Total Sales',
                data: totals.length ? totals : [0],
                borderColor: '#0077b6',
                backgroundColor: 'rgba(0, 180, 216, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#03045e',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
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
                        },
                        font: {
                            size: 12,
                            weight: 'bold'
                        }
                    },
                    grid: {
                        color: 'rgba(0, 119, 182, 0.1)',
                        drawBorder: false
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: '{{ ucfirst($period) }} Period',
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    },
                    ticks: {
                        font: {
                            size: 12,
                            weight: 'bold'
                        }
                    },
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(3, 4, 94, 0.8)',
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 12
                    },
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
