<?php

namespace App\Http\Controllers;

use App\Models\Historical;
use App\Models\User;
use App\Models\Payment;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // Import Carbon for date handling
use Illuminate\Routing\Controller;
use Phpml\Regression\LeastSquares;

class DashController extends Controller
{
    /**
     * Display the dashboard with sales data.
     */
    public function login()
    {
        return view('adminDash.dashboard');
    }

    public function dashboard() {
        $pendingOrdersCount = Order::where('status', 'pending')->count();
        return view('components.layoutDash', compact('pendingOrdersCount'));
    }


//

    public function customerList()
    {
        // Retrieve all users from the database
        $users = User::all();

        // Pass the users to the view
        return view('adminDash.customerList', ['users' => $users]);
    }

    /**
     * Get sales data for the chart based on the selected period.
     */
    public function salesChart(Request $request)
    {
        // Set the default period to 'monthly'
        $period = $request->input('period', 'monthly');


        // Kunin ang sales data depende sa period
        $salesData = [];

        switch ($period) {
            case 'weekly':
                $salesData = Payment::where('purchase_date', '>=', now()->subWeeks(1))
                    ->selectRaw('DATE(purchase_date) as date, SUM(price) as total_sales')
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get()
                    ->toArray();
                break;

            case 'monthly':
                $salesData = Payment::where('purchase_date', '>=', now()->subMonths(1))
                    ->selectRaw('DATE(purchase_date) as date, SUM(price) as total_sales')
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get()
                    ->toArray();
                break;

            case 'yearly':
                $salesData = Payment::where('purchase_date', '>=', now()->subYears(1))
                    ->selectRaw('DATE(purchase_date) as date, SUM(price) as total_sales')
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get()
                    ->toArray();
                break;

            default:
                break;
        }

        // logger()->info('Sales Data:', $salesData);

       // Kunin ang chart data (actual and predicted sales)
    $chartData = $this->getChartDataForPrediction();

        // Prepare other data for the view
        $products = Product::all();
        $stocks = $products->pluck('stock', 'product_Name');

        $totalSalesToday = Payment::whereDate('purchase_date', Carbon::today())->sum('price');
        $totalSales = Payment::sum('price');

        $averageDailySales = Historical::where('period_type', 'daily')->avg('total_sales');
        $averageWeeklySales = Historical::where('period_type', 'weekly')->avg('total_sales');
        $averageMonthlySales = Historical::where('period_type', 'monthly')->avg('total_sales');

        return view('adminDash.dashboard', compact('stocks', 'totalSalesToday', 'totalSales', 'salesData', 'period', 'averageDailySales', 'averageWeeklySales', 'averageMonthlySales', 'chartData'));
    }





    // Private function para kumuha ng weekly sales data at i-predict gamit ang Least Squares (Linear Regression)
    private function getWeeklySalesDataForPrediction()
    {
        // Kunin ang historical sales data mula sa Historical table
        $salesData = Historical::where('period_type', 'weekly')
            ->orderBy('start_date', 'asc')
            ->get(['start_date', 'total_sales']);

        // I-prepare ang data para sa machine learning
        $samples = [];
        $targets = [];

        foreach ($salesData as $data) {
            $weekNumber = \Carbon\Carbon::parse($data->start_date)->week();
            $samples[] = [$weekNumber];
            $targets[] = (float) $data->total_sales;
        }

        if (empty($samples)) {
            return ['error' => 'No sales data available for prediction.'];
        }

        // Train the linear regression model
        $regressor = new LeastSquares();
        $regressor->train($samples, $targets);

        // Pag-predict ng sales para sa susunod na tatlong hanggang anim na buwan (approx. 12 to 24 weeks)
        $predictedSales = [];
        $currentWeek = \Carbon\Carbon::now()->week();

        for ($i = 1; $i <= 24; $i++) {  // Mag-predict for 24 weeks (6 months)
            $predictedSales[] = max(0, $regressor->predict([$currentWeek + $i]));
        }

        return $predictedSales;
    }

    public function getChartDataForPrediction()
    {
        $salesData = $this->getWeeklySalesDataForPrediction();
        logger()->info('Sales Data:', $salesData);

        if (isset($salesData['error'])) {
            return ['error' => $salesData['error']];
        }

        $predictedData = [];
        $currentDate = \Carbon\Carbon::now();

        foreach ($salesData as $index => $sales) {
            $weekDate = $currentDate->copy()->addWeeks($index + 1);
            $predictedData[] = [
                'week' => $weekDate->format('Y-m-d'),  // Format as 'YYYY-MM-DD' for chart labels
                'predicted_sales' => $sales,
            ];
        }

        return $predictedData;
    }


public function testHistoricalData()
{
    // Existing and new data points
    Historical::create(['period_type' => 'weekly', 'start_date' => '2024-10-01', 'end_date' => '2024-10-07', 'total_sales' => 450.00]);
    Historical::create(['period_type' => 'weekly', 'start_date' => '2024-10-08', 'end_date' => '2024-10-14', 'total_sales' => 470.00]);
    Historical::create(['period_type' => 'weekly', 'start_date' => '2024-10-15', 'end_date' => '2024-10-21', 'total_sales' => 480.00]);
    Historical::create(['period_type' => 'weekly', 'start_date' => '2024-10-22', 'end_date' => '2024-10-28', 'total_sales' => 500.00]);
    Historical::create(['period_type' => 'weekly', 'start_date' => '2024-10-29', 'end_date' => '2024-11-04', 'total_sales' => 520.00]);
    Historical::create(['period_type' => 'weekly', 'start_date' => '2024-11-05', 'end_date' => '2024-11-11', 'total_sales' => 530.00]);
    Historical::create(['period_type' => 'weekly', 'start_date' => '2024-11-12', 'end_date' => '2024-11-18', 'total_sales' => 550.00]);
    Historical::create(['period_type' => 'weekly', 'start_date' => '2024-11-19', 'end_date' => '2024-11-25', 'total_sales' => 570.00]);
    Historical::create(['period_type' => 'weekly', 'start_date' => '2024-11-26', 'end_date' => '2024-12-02', 'total_sales' => 590.00]);
    Historical::create(['period_type' => 'weekly', 'start_date' => '2024-12-03', 'end_date' => '2024-12-09', 'total_sales' => 600.00]);
    Historical::create(['period_type' => 'weekly', 'start_date' => '2024-12-10', 'end_date' => '2024-12-16', 'total_sales' => 620.00]);
    Historical::create(['period_type' => 'weekly', 'start_date' => '2024-12-17', 'end_date' => '2024-12-23', 'total_sales' => 640.00]);
    Historical::create(['period_type' => 'weekly', 'start_date' => '2024-12-24', 'end_date' => '2024-12-30', 'total_sales' => 650.00]);
    Historical::create(['period_type' => 'weekly', 'start_date' => '2024-12-24', 'end_date' => '2024-12-30', 'total_sales' => 100.00]);

    return view('adminDash.purchase'); // Confirm data saving and view your chart
}









    // private function leastSquaresPrediction($salesData)
    // {
    //     // Gamitin ang PHP ML library para sa linear regression
    //     $samples = [];
    //     $targets = [];

    //     // Gawin ang mga samples at targets mula sa iyong sales data
    //     foreach ($salesData as $key => $data) {
    //         $samples[] = [$key]; // X axis (index)
    //         $targets[] = $data['total_sales']; // Y axis (sales)
    //     }

    //     // Mag-train ng linear regression model
    //     $regression = new \Phpml\Regression\LeastSquares();
    //     $regression->train($samples, $targets);

    //     // Predict the next 6 data points
    //     $predictions = [];
    //     $lastIndex = count($salesData);

    //     for ($i = 1; $i <= 6; $i++) {
    //         $predictions[] = $regression->predict([$lastIndex + $i]);
    //     }

    //     return $predictions;
    // }



    /**
     * Show other methods if necessary.
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
