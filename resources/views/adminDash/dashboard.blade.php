@extends('components.layoutDash')


@section('dash')

<style>
    /* Mobile Styles */
@media (max-width: 767px) {
  .min-h-screen {
    min-height: auto;
  }

  .grid-cols-1 {
    grid-template-columns: 1fr;
  }

  .sm\:grid-cols-2 {
    grid-template-columns: repeat(2, 1fr);
  }

  .lg\:grid-cols-3 {
    grid-template-columns: repeat(1, 1fr);
  }

  .p-5 {
    padding: 1.25rem;
  }

  .text-2xl {
    font-size: 1.5rem;
    line-height: 2rem;
  }

  .text-3xl {
    font-size: 1.875rem;
    line-height: 2.25rem;
  }

  #salesChart {
    height: 300px !important;
  }
}

/* Desktop Styles */
@media (min-width: 768px) {
  .sm\:grid-cols-2 {
    grid-template-columns: repeat(2, 1fr);
  }

  .lg\:grid-cols-3 {
    grid-template-columns: repeat(3, 1fr);
  }
}

/* New header styles */
.dashboard-header {
    background: linear-gradient(to right, #ffffff, #f0f9ff);
    border-bottom: 1px solid #e5e7eb;
    margin-bottom: 2rem;
    padding: 1.5rem 0;
}
</style>


<div class="min-h-screen bg-gradient-to-br from-blue-50 to-cyan-50 py-8 px-4">
    <div class="max-w-7xl mx-auto space-y-6">
        <!-- New Header Section -->
    <div class="dashboard-header">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                <!-- Title and Overview Section -->
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-3">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Sales Overview</h1>
                            <p class="text-sm text-gray-500 mt-1">Dashboard Analytics</p>
                        </div>
                    </div>
                </div>

                <!-- Period Select -->
                <div class="flex items-center space-x-4">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-2">
                        <form action="{{ route('dashboard') }}" method="GET" class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <select id="period" name="period"
                                    class="bg-transparent border-none text-gray-900 text-sm focus:ring-0 focus:outline-none"
                                    onchange="this.form.submit()">
                                <option value="weekly" {{ $period == 'weekly' ? 'selected' : '' }}>Weekly View</option>
                                <option value="monthly" {{ $period == 'monthly' ? 'selected' : '' }}>Monthly View</option>
                                <option value="yearly" {{ $period == 'yearly' ? 'selected' : '' }}>Yearly View</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Today's Sales -->
            <div class="bg-white rounded-lg border border-gray-200 shadow-lg">
              <div class="p-5">
                <div class="flex items-center justify-between">
                  <div class="flex items-center space-x-3">
                    <div class="p-3 bg-blue-100 rounded-lg">
                      <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                      </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Today's Sales</h3>
                  </div>
                  <div class="flex items-center space-x-2">
                    <span class="text-sm font-medium text-gray-500">Last 24 hours</span>
                  </div>
                </div>
                <div class="mt-4 flex items-center space-x-2">
                  <p class="text-3xl font-bold text-gray-900">₱{{ number_format($totalSalesToday, 2) }}</p>
                  <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                  </svg>
                </div>
              </div>
            </div>

            <!-- Total Sales -->
            <div class="bg-white rounded-lg border border-gray-200 shadow-lg">
              <div class="p-5">
                <div class="flex items-center justify-between">
                  <div class="flex items-center space-x-3">
                    <div class="p-3 bg-green-100 rounded-lg">
                      <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12a8 8 0 01-8 8v-1a7 7 0 007-7V4a3 3 0 00-3-3v1a2 2 0 012 2v8a6 6 0 01-6 6v-1a5 5 0 005-5V4a3 3 0 00-3-3v1a2 2 0 012 2v8a4 4 0 11-8 0V4a2 2 0 012-2V1a3 3 0 00-3 3v8a8 8 0 1016 0z"></path>
                      </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Total Sales</h3>
                  </div>
                  <div class="flex items-center space-x-2">
                    <span class="text-sm font-medium text-gray-500">All time</span>
                  </div>
                </div>
                <div class="mt-4 flex items-center space-x-2">
                  <p class="text-3xl font-bold text-gray-900">₱{{ number_format($totalSales, 2) }}</p>
                  <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                  </svg>
                </div>
              </div>
            </div>

            {{-- <!-- Predicted Sales -->
            <div class="bg-white rounded-lg border border-gray-200 shadow-lg">
              <div class="p-5">
                <div class="flex items-center justify-between">
                  <div class="flex items-center space-x-3">
                    <div class="p-3 bg-purple-100 rounded-lg">
                      <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                      </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Predicted Sales</h3>
                  </div>
                </div>
                <div class="mt-4">
                  @if($predictedSales === 'no data yet')
                    <p class="text-xl font-semibold text-red-500">No data yet</p>
                  @else
                    <p class="text-3xl font-bold text-gray-900">₱{{ number_format((float) $predictedSales, 2) }}</p>
                    <p class="text-sm text-gray-500 mt-1">Based on recent trends</p>
                  @endif
                </div>
              </div>
            </div> --}}

            <form action="{{ route('addd') }}" method="post" class="space-y-6">
                @csrf
                <div>
                    <button type="submit"
                        class="w-full bg-[#0077b6] hover:bg-[#00b4d8] text-white font-bold py-3 px-4 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-[#00b4d8] focus:ring-opacity-50 transition duration-300 ease-in-out transform hover:-translate-y-1">
                        Insert Data
                    </button>
                </div>
            </form>



            <!-- Daily Average Sales -->
            <div class="bg-white rounded-lg border border-gray-200 shadow-lg">
              <div class="p-5">
                <div class="flex items-center justify-between">
                  <div class="flex items-center space-x-3">
                    <div class="p-3 bg-yellow-100 rounded-lg">
                      <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                      </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Daily Average</h3>
                  </div>
                </div>
                <div class="mt-4 flex items-center space-x-2">
                  <p class="text-3xl font-bold text-gray-900">₱{{ number_format($averageDailySales, 2) }}</p>
                  <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                  </svg>
                </div>
              </div>
            </div>

            <!-- Weekly Average Sales -->
            <div class="bg-white rounded-lg border border-gray-200 shadow-lg">
              <div class="p-5">
                <div class="flex items-center justify-between">
                  <div class="flex items-center space-x-3">
                    <div class="p-3 bg-indigo-100 rounded-lg">
                      <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                      </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Weekly Average</h3>
                  </div>
                </div>
                <div class="mt-4 flex items-center space-x-2">
                  <p class="text-3xl font-bold text-gray-900">₱{{ number_format($averageWeeklySales, 2) }}</p>
                  <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                  </svg>
                </div>
              </div>
            </div>

            <!-- Monthly Average Sales -->
            <div class="bg-white rounded-lg border border-gray-200 shadow-lg">
              <div class="p-5">
                <div class="flex items-center justify-between">
                  <div class="flex items-center space-x-3">
                    <div class="p-3 bg-purple-100 rounded-lg">
                      <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                      </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Monthly Average</h3>
                  </div>
                </div>
                <div class="mt-4 flex items-center space-x-2">
                  <p class="text-3xl font-bold text-gray-900">₱{{ number_format($averageMonthlySales, 2) }}</p>
                  <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
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

<div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-300">
    <div class="p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900">Sales Prediction Analysis</h3>
            </div>
            <div class="flex items-center space-x-1">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <span class="text-sm text-gray-500">Forecast View</span>
            </div>
        </div>

        {{-- <!-- Check if there is insufficient data -->
        @if(isset($chartData['error']) && $chartData['error'] == 'Insufficient data')
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-800 p-4 rounded-lg mb-4">
                <strong>Warning:</strong> Insufficient data available for predictions.
            </div>
        @else --}}
            <!-- Display prediction chart -->
            <div class="h-[400px]">
                <canvas id="predictionChart"></canvas>
            </div>
        {{-- @endif --}}
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
    const chartData = @json($chartData); // Pasok ang PHP chart data sa JavaScript
console.log('Chart Data:', chartData);

const setupPredictionChart = () => {
    const predictionCtx = document.getElementById('predictionChart').getContext('2d');

    if (!chartData || chartData.length < 6) {
        console.error('Insufficient sales data for the chart.');
        return;
    }

    const predictedValues = chartData.map(data => data.predicted_sales);
    const weeks = chartData.map(data => {
        const weekDate = new Date(data.week);  // Convert week to a Date object
        const month = weekDate.toLocaleString('default', { month: 'short' });  // Get short month name
        const year = weekDate.getFullYear();
        return `${month} ${year}`;  // Format as "Mar 2024", "Apr 2024", etc.
    });

    new Chart(predictionCtx, {
        type: 'line',
        data: {
            labels: weeks,
            datasets: [
                {
                    label: 'Predicted Sales',
                    data: predictedValues,
                    borderColor: '#7c3aed',
                    backgroundColor: '#c4b5fd33',
                    borderWidth: 2,
                    borderDash: [5, 5],
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#7c3aed',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointHoverRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: value => '₱' + value.toLocaleString() // Format sa peso
                    }
                }
            }
        }
    });
};

document.addEventListener('DOMContentLoaded', setupPredictionChart);


</script>
@endsection
