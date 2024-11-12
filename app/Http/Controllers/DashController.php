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

    // Sales prediction
    $predictedSales = $this->predictSales();

    // Initialize an empty array for sales data
    $salesData = [];

    // Get sales data based on the selected period
    switch ($period) {
        case 'weekly':
            $salesData = Payment::where('purchase_date', '>=', now()->subWeeks(1))
                ->selectRaw('DATE(purchase_date) as date, SUM(price) as total_sales')
                ->groupBy('date')
                ->orderBy('date')
                ->get();
            break;

        case 'monthly':
            $salesData = Payment::where('purchase_date', '>=', now()->subMonths(1))
                ->selectRaw('DATE(purchase_date) as date, SUM(price) as total_sales')
                ->groupBy('date')
                ->orderBy('date')
                ->get();
            break;

        case 'yearly':
            $salesData = Payment::where('purchase_date', '>=', now()->subYears(1))
                ->selectRaw('DATE(purchase_date) as date, SUM(price) as total_sales')
                ->groupBy('date')
                ->orderBy('date')
                ->get();
            break;

        default:
            // Default case can return monthly or whatever is appropriate
            break;
    }

    $products = Product::all(); // Kumuha ng lahat ng produkto mula sa database
    $stocks = $products->pluck('stock', 'product_Name'); // Kunin lang ang pangalan at stock ng produkto

    // Total sales for today
    $totalSalesToday = Payment::whereDate('purchase_date', Carbon::today())->sum('price');

    // Total sales overall
    $totalSales = Payment::sum('price');

    // Get average weekly sales from the historicals table
    $averageWeeklySales = Historical::where('period_type', 'weekly')->avg('total_sales');

    // Get average monthly sales from the historicals table
    $averageMonthlySales = Historical::where('period_type', 'monthly')->avg('total_sales');

    // Sales data for charting (this is already inside your switch block)
    $salesData = Payment::select(DB::raw('DATE(purchase_date) as date, SUM(price) as total_sales'))
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();

    // Return the view with the required data, including the averages
    return view('adminDash.dashboard', compact('stocks','totalSalesToday', 'totalSales', 'salesData', 'period', 'predictedSales', 'averageWeeklySales', 'averageMonthlySales'));
}


private function predictSales()
{
    // Kunin ang historical sales data mula sa database
    $salesData = Payment::select(DB::raw('DATE(purchase_date) as date'), 'price')
        ->orderBy('date', 'asc')
        ->get();

    // Check kung may sapat na data para mag-predict (halimbawa: 2 o higit pang data points)
    if ($salesData->count() < 2) {
        return ['message' => 'Not enough data to calculate'];
    }

    // I-convert ang sales data sa format na magagamit ng machine learning
    $samples = [];
    $targets = [];
    foreach ($salesData as $index => $data) {
        $samples[] = [$index]; // Positional index bilang sample input
        $targets[] = $data->price; // Corresponding sales bilang target output
    }

    // Gumamit ng LeastSquares regression para sa training ng model
    $regression = new LeastSquares();
    $regression->train($samples, $targets);

    // I-predict ang sales para sa susunod na araw
    $futureIndex = count($samples); // Index para sa future prediction
    $predictedSales = $regression->predict([$futureIndex]);

    return $predictedSales;
}


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
