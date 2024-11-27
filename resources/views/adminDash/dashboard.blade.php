@extends('components.layoutDash')

@section('title', 'Admin Dashboard')
@section('dash')

<style>
      /* Mobile Styles */
@media (max-width: 767px) {
  /* Chart container adjustments */
  .max-w-7xl {
    padding: 1rem;
  }

  /* Chart height adjustments */
  .h-[400px] {
    height: 300px !important;
  }

  /* Chart padding adjustments */
  .p-6 {
    padding: 1rem;
  }

  /* Header adjustments */
  .text-xl {
    font-size: 1.125rem;
    line-height: 1.75rem;
  }

  /* Reduce icon size */
  .w-6, .h-6 {
    width: 1.25rem;
    height: 1.25rem;
  }

  /* Adjust spacing */
  .mb-6 {
    margin-bottom: 1rem;
  }

  .space-x-3 > * + * {
    margin-left: 0.5rem;
  }

  /* Chart legend adjustments */
  #salesPredictionChart {
    max-height: 300px !important;
  }
}

/* Tablet Styles */
@media (min-width: 768px) and (max-width: 1023px) {
  .h-[400px] {
    height: 350px !important;
  }

  .max-w-7xl {
    padding: 1.5rem;
  }
}

/* Ensure Chart.js is responsive */
canvas#salesPredictionChart {
  max-width: 100%;
  height: auto !important;
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
                </div>
            </div>
        </div>

        <a href="{{ route('order') }}">
            <div class="bg-white rounded-lg border border-gray-200 shadow-lg mt-5">
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="p-3 bg-orange-100 rounded-lg">
                                <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Pending Orders</h3>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm font-medium text-gray-500">Current</span>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center space-x-2">
                        <p class="text-3xl font-bold text-red-900">{{ $pendingOrders ?? 0 }}</p>

                        <!-- Notification badge -->
                        @if($pendingOrders > 0)
                            <span class="inline-block w-3 h-3 bg-red-500 rounded-full animate-pulse absolute top-0 right-0 mt-2 mr-2"></span>
                        @endif

                        <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </a>

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

            <div class="bg-white rounded-lg border border-gray-200 shadow-lg cursor-pointer hover:shadow-xl transition-all" onclick="openExpensesModal()">
                <div class="p-5">
                  <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                      <div class="p-3 bg-red-100 rounded-lg">
                        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4M12 20V4"></path>
                        </svg>
                      </div>
                      <h3 class="text-lg font-medium text-gray-900">Today's Expenses</h3>
                    </div>
                    <div class="flex items-center space-x-2">
                      <span class="text-sm font-medium text-gray-500">Last 24 hours</span>
                    </div>
                  </div>
                  <div class="mt-4 flex items-center space-x-2">
                    <p class="text-3xl font-bold text-gray-900">₱<span id="totalExpenses">{{ number_format($totalExpensesToday, 2) }}</span></p>
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"></path>
                    </svg>
                  </div>
                </div>
              </div>

              <!-- Modal -->
<div id="expensesModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
      <div class="mt-3">
        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Update Today's Expenses</h3>
        <div class="mt-2">
          <!-- Form for updating an expense -->
<form id="expensesForm" class="space-y-4" method="POST" action="{{ route('finalize')}}">
    @csrf
    <div>
      <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Amount</label>
      <div class="relative">
        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">₱</span>
        <input type="number" id="amount" name="amount" step="0.01" class="pl-8 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="0.00">
      </div>
    </div>


    <div class="flex justify-end space-x-3">
      <button type="button" onclick="closeExpensesModal()" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-medium rounded-md">
        Cancel
      </button>
      <!-- Button for updating an expense -->
      <button type="submit" formaction="{{ route('update') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md">
        Update
      </button>
      <!-- Button for finalizing expenses -->
      <button type="submit" formaction="{{ route('finalize') }}" id="doneBtn" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md">
        Done
      </button>
    </div>
  </form>

        </div>
      </div>
    </div>
  </div>

 <!-- Modal Backdrop -->
<div id="noExpensesModal" class="fixed inset-0 flex items-center justify-center z-50 opacity-0 pointer-events-none transition-opacity duration-300">
    <!-- Backdrop overlay -->
    <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm"></div>

    <!-- Modal Content -->
    <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-md mx-4 transform transition-all duration-300 scale-95">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Walang Expenses</h2>
        </div>

        <!-- Body -->
        <div class="p-6">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <!-- Info Icon -->
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-gray-600 dark:text-gray-300">Walang expenses na naitala ngayong araw. Pakisuri ang iyong mga datos.</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="p-6 border-t border-gray-200 dark:border-gray-700 flex justify-end">
            <button id="closeModalBtn" class="px-5 py-2.5 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg text-sm transition-colors duration-300 focus:ring-4 focus:ring-blue-300 focus:outline-none">
                Okay
            </button>
        </div>
    </div>
</div>



  <!-- Monthly Average Profit -->
<div class="bg-white rounded-lg border border-gray-200 shadow-lg">
    <div class="p-5">
      <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
          <div class="p-3 bg-emerald-100 rounded-lg">
            <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
          </div>
          <h3 class="text-lg font-medium text-gray-900">Monthly Profit Average</h3>
        </div>
      </div>
      <div class="mt-4 flex items-center space-x-2">
        <p class="text-3xl font-bold text-gray-900">₱{{ number_format($profit, 2) }}</p>
        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
        </svg>
      </div>
    </div>
  </div>

  <!-- Monthly Average Expenses -->
  <div class="bg-white rounded-lg border border-gray-200 shadow-lg">
    <div class="p-5">
      <div class="flex items-center justify-between">
        <div class="flex items-center space-x-3">
          <div class="p-3 bg-red-100 rounded-lg">
            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4M12 20V4"></path>
            </svg>
          </div>
          <h3 class="text-lg font-medium text-gray-900">Monthly Expenses Average</h3>
        </div>
      </div>
      <div class="mt-4 flex items-center space-x-2">
        <p class="text-3xl font-bold text-gray-900">₱{{ number_format($totalExpenses, 2) }}</p>
        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"></path>
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
                    <h3 class="text-lg font-medium text-gray-900">Monthly Average Income</h3>
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

      <!-- Wrap both charts in a grid container -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 max-w-7xl mx-auto p-6">
    <!-- Sales Chart -->
    <div class="bg-white rounded-lg border border-gray-200 shadow-lg overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Sales & Predictions Overview</h2>
                        <p class="text-sm text-gray-500">Monthly comparison of actual vs predicted sales</p>
                    </div>
                </div>
            </div>
            <div class="h-96 sm:h-[400px]">
                <canvas id="salesPredictionChart" style="display: {{ $hasData ? 'block' : 'none' }}"></canvas>
            </div>
        </div>
    </div>

    <!-- Customer Locations Chart -->
    <div class="bg-white rounded-lg border border-gray-200 shadow-lg overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Customer Location Distribution</h2>
                        <p class="text-sm text-gray-500">Geographic distribution of customer base</p>
                    </div>
                </div>
            </div>
            <div class="h-96 sm:h-[400px]">
                <canvas id="locationChart"></canvas>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-lg border border-gray-200 shadow-lg overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-3">
                    <div class="p-2 bg-red-100 rounded-lg">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Monthly Expenses Breakdown</h2>
                        <p class="text-sm text-gray-500">Detailed expense tracking and analysis</p>
                    </div>
                </div>
            </div>
            <div class="h-96 sm:h-[400px]">
                <canvas id="expensesChart"></canvas>
            </div>
        </div>
    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
<script>
   const locationCtx = document.getElementById('locationChart').getContext('2d');
const locationChart = new Chart(locationCtx, {
    type: 'bar',
    data: {
        labels: @json($locationLabels),
        datasets: [{
            label: 'Number of Customers',
            data: @json($locationCounts),
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});



    const actualSales = @json($actualSales);
    const predictedSales = @json($predictedSales);

    // Format the month names for the x-axis
    const formatMonth = month => moment(month, "YYYY-MM").format("MMM YYYY");

    const actualSalesData = actualSales.map(item => ({
        month: formatMonth(item.month), // Format month to "MMM YYYY"
        sales: item.sales
    }));

    const predictedSalesData = predictedSales.map(item => ({
        month: formatMonth(item.month), // Format month to "MMM YYYY"
        sales: item.sales
    }));

    const ctx = document.getElementById('salesPredictionChart').getContext('2d');

    new Chart(ctx, {
    type: 'line',
    data: {
        labels: [
            ...actualSalesData.map(d => d.month),
            ...predictedSalesData.map(d => d.month)
        ],
        datasets: [
            {
                label: 'Actual Sales',
                data: [
                    ...actualSalesData.map(d => d.sales),
                    ...Array(predictedSalesData.length).fill(null)
                ],
                borderColor: '#2563eb',
                tension: 0.4,
                borderWidth: 2 // Default line thickness
            },
            {
                label: 'Predicted Sales',
                data: [
                    ...Array(actualSalesData.length).fill(null),
                    ...predictedSalesData.map(d => d.sales)
                ],
                borderColor: '#9333ea',
                tension: 0.4,
                borderWidth: 2
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, // Allow the height to adjust properly
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    font: {
                        size: 12 // Smaller font for mobile
                    }
                }
            }
        },
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Month',
                    font: {
                        size: 14 // Adjust text size for readability
                    }
                },
                ticks: {
                    maxRotation: 45, // Avoid text overlapping
                    minRotation: 0
                }
            },
            y: {
                title: {
                    display: true,
                    text: 'Sales',
                    font: {
                        size: 14
                    }
                }
            }
        }
    }
});
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('expensesChart').getContext('2d');

    const monthlyExpenses = @json($monthlyExpenses);
    const labels = monthlyExpenses.map(item => item.month);
    const data = monthlyExpenses.map(item => parseFloat(item.amount));

    new Chart(ctx, {
        type: 'line', // Baguhin ang type sa 'line'
        data: {
            labels: labels,
            datasets: [{
                label: 'Monthly Expenses',
                data: data,
                fill: false, // Walang fill sa ilalim ng linya
                borderColor: 'rgba(54, 162, 235, 1)', // Kulay ng linya
                borderWidth: 2, // Lapad ng linya
                tension: 0.4 // Smoothing ng line graph
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true // Siguraduhing magsimula sa 0
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    });
});


let totalExpenses = 0;
// For demonstration purposes, open the modal after 1 second
setTimeout(openModal, 1000);

function openExpensesModal() {
  document.getElementById('expensesModal').classList.remove('hidden');
}

function closeExpensesModal() {
  document.getElementById('expensesModal').classList.add('hidden');
  document.getElementById('expensesForm').reset();
}

function updateExpenses() {
  const amount = parseFloat(document.getElementById('amount').value) || 0;
  totalExpenses += amount;
  document.getElementById('totalExpenses').textContent = totalExpenses.toLocaleString('en-US', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  });
  document.getElementById('expensesForm').reset();
}

function submitExpenses() {
  // Here you would typically send the data to your backend
  // For now, we'll just close the modal
  closeExpensesModal();
  // You can add an AJAX call here to save the total expenses
}

// Close modal when clicking outside
window.onclick = function(event) {
  const modal = document.getElementById('expensesModal');
  if (event.target == modal) {
    closeExpensesModal();
  }
}

</script>
@endsection
