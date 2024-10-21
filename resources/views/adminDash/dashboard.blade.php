@extends('components.layoutDash')

@section('dash')
<div class="min-h-screen bg-gray-50 py-8 px-4">
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900">Sales Dashboard</h2>

            <!-- Period Select -->
            <form action="{{ route('dashboard') }}" method="GET">
                <select id="period" name="period"
                        class="bg-white border border-gray-200 text-gray-900 text-sm rounded-lg px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500"
                        onchange="this.form.submit()">
                    <option value="weekly" {{ $period == 'weekly' ? 'selected' : '' }}>Weekly View</option>
                    <option value="monthly" {{ $period == 'monthly' ? 'selected' : '' }}>Monthly View</option>
                    <option value="yearly" {{ $period == 'yearly' ? 'selected' : '' }}>Yearly View</option>
                </select>
            </form>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Today's Sales Card -->
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <div class="p-2 bg-blue-50 rounded-lg">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-500">Today's Sales</span>
                        </div>
                        <span class="text-xs font-medium text-gray-400">Last 24 hours</span>
                    </div>
                    <div class="mt-3">
                        <p class="text-2xl font-bold text-gray-900">₱{{ number_format($totalSalesToday, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Sales Card -->
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <div class="p-2 bg-green-50 rounded-lg">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-500">Total Sales</span>
                        </div>
                        <span class="text-xs font-medium text-gray-400">All time</span>
                    </div>
                    <div class="mt-3">
                        <p class="text-2xl font-bold text-gray-900">₱{{ number_format($totalSales, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Card -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Sales Overview</h3>
                    <span class="text-sm text-gray-500">{{ ucfirst($period) }} Data</span>
                </div>
                <div class="h-[400px]">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

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
            case 'weekly': return momentDate.format('ddd');
            case 'monthly': return momentDate.format('MMM D');
            case 'yearly': return momentDate.format('MMM YYYY');
            default: return date;
        }
    };

    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: dates.map(formatDate),
            datasets: [{
                label: 'Sales',
                data: totals,
                borderColor: '#2563eb',
                backgroundColor: '#93c5fd33',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#2563eb',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            scales: {
                y: {
                    beginAtZero: true,
                    border: {
                        display: false
                    },
                    grid: {
                        color: '#e5e7eb',
                        drawBorder: false
                    },
                    ticks: {
                        callback: value => '₱' + value.toLocaleString(),
                        font: { size: 11 }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: { size: 11 }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#1e40af',
                    padding: 12,
                    titleFont: { size: 13 },
                    bodyFont: { size: 12 },
                    callbacks: {
                        label: context => '₱' + context.parsed.y.toLocaleString()
                    }
                }
            }
        }
    });
</script>
@endsection
