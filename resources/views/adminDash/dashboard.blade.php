@extends('components.layoutDash')

@section('dash')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-cyan-50 py-8 px-4">
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <h2 class="text-2xl font-bold text-gray-900">Sales Dashboard</h2>
            </div>

            <!-- Period Select with Calendar Icon -->
            <form action="{{ route('dashboard') }}" method="GET" class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <select id="period" name="period"
                        class="bg-white border border-gray-200 text-gray-900 text-sm rounded-lg px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500"
                        onchange="this.form.submit()">
                    <option value="weekly" {{ $period == 'weekly' ? 'selected' : '' }}>Weekly View</option>
                    <option value="monthly" {{ $period == 'monthly' ? 'selected' : '' }}>Monthly View</option>
                    <option value="yearly" {{ $period == 'yearly' ? 'selected' : '' }}>Yearly View</option>
                </select>
            </form>
        </div>

        <!-- Primary Stats Grid - Current Performance -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Today's Sales Card -->
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <div class="p-2 bg-blue-50 rounded-lg">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-500">Today's Sales</span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-xs font-medium text-gray-400">Last 24 hours</span>
                        </div>
                    </div>
                    <div class="mt-3 flex items-center space-x-2">
                        <p class="text-2xl font-bold text-gray-900">₱{{ number_format($totalSalesToday, 2) }}</p>
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Predicted Sales Card -->
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <div class="p-2 bg-purple-50 rounded-lg">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-500">Predicted Sales (Tomorrow)</span>
                        </div>
                    </div>
                    <div class="mt-3">
                        @if($predictedSales === 'no data yet')
                            <p class="text-xl font-semibold text-red-500">No data yet</p>
                        @else
                            <p class="text-2xl font-bold text-gray-900">₱{{ number_format((float) $predictedSales, 2) }}</p>
                            <p class="text-xs text-gray-500 mt-1">Based on recent trends</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Secondary Stats Grid - Historical Performance -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <!-- Average Weekly Sales Card -->
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <div class="p-2 bg-indigo-50 rounded-lg">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-500">Weekly Average</span>
                        </div>
                    </div>
                    <div class="mt-3 flex items-center space-x-2">
                        <p class="text-2xl font-bold text-gray-900">₱{{ number_format($averageWeeklySales, 2) }}</p>
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Average Monthly Sales Card -->
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <div class="p-2 bg-purple-50 rounded-lg">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-500">Monthly Average</span>
                        </div>
                    </div>
                    <div class="mt-3 flex items-center space-x-2">
                        <p class="text-2xl font-bold text-gray-900">₱{{ number_format($averageMonthlySales, 2) }}</p>
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Sales Card -->
            <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <div class="p-2 bg-green-50 rounded-lg">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12a8 8 0 01-8 8v-1a7 7 0 007-7V4a3 3 0 00-3-3v1a2 2 0 012 2v8a6 6 0 01-6 6v-1a5 5 0 005-5V4a3 3 0 00-3-3v1a2 2 0 012 2v8a4 4 0 11-8 0V4a2 2 0 012-2V1a3 3 0 00-3 3v8a8 8 0 1016 0z"/>
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-500">Total Sales</span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                            </svg>
                            <span class="text-xs font-medium text-gray-400">All time</span>
                        </div>
                    </div>
                    <div class="mt-3 flex items-center space-x-2">
                        <p class="text-2xl font-bold text-gray-900">₱{{ number_format($totalSales, 2) }}</p>
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Stocks Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            @foreach($stocks as $productName => $stocks)
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <div class="p-2 bg-yellow-50 rounded-lg">
                                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13h1v4H3zM10 3h1v10h-1zM17 8h1v5h-1z"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-500">Stock of {{ $productName }}</span>
                            </div>
                        </div>
                        <div class="mt-3 flex items-center space-x-2">
                            <p class="text-2xl font-bold text-gray-900">{{ $stocks }} units</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Sales Chart -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-300">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900">Sales Overview</h3>
                    </div>
                    <div class="flex items-center space-x-1">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-sm text-gray-500">{{ ucfirst($period) }} Data</span>
                    </div>
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
