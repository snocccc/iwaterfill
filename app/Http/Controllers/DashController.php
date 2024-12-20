<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Expense_sums;
use App\Models\Historical;
use App\Models\User;
use App\Models\Payment;
use App\Models\Order;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
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

    public function customerList()
{
    // Retrieve paginated users with 'user' role from the database
    $users = User::where('role', 'user')->paginate(10); // 10 users per page

    // Pass the users to the view
    return view('adminDash.customerList', ['users' => $users]);
}




    // Method para mag-update ng expense
public function updateExpense(Request $request)
{
    $request->validate([
        'amount' => 'required|numeric|min:0',
    ]);

    // Insert a new expense record sa database
    Expense::create([
        'period_type' => 'monthly', // Maaari mong baguhin ito depende sa kailangan mo (e.g., 'daily', 'weekly', 'monthly')
        'amount' => $request->input('amount'),
        'start_date' => Carbon::today()->toDateString(),
        'end_date' => Carbon::today()->toDateString(),
    ]);

    return redirect()->back()->with('success', 'Expense updated successfully.');
}


public function finalizeExpenses()
{
 // Tawagin ang mergeDuplicateExpenses para tanggalin ang duplicate
 $this->mergeDuplicateExpenses();

    // Kunin ang total ng expenses para sa kasalukuyang araw
    $totalExpensesToday = Expense::whereDate('created_at', Carbon::today())->sum('amount');

    if ($totalExpensesToday == 0) {
        return redirect()->back()->with('info', 'Walang expenses na naitala ngayong araw.');
    }

    // I-save ang total na ito sa database bilang isang summary record
    DB::table('expense_sums')->insert([
        'period_type' => 'daily',
        'amount' => $totalExpensesToday,
        'start_date' => Carbon::today()->toDateString(),
        'end_date' => Carbon::today()->toDateString(),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // I-delete ang mga individual expenses na kasama sa total
    Expense::whereDate('created_at', Carbon::today())->delete();

    // Check kung umabot na ng 30 records ang mga daily summaries
    $dailySummariesCount = DB::table('expense_sums')
        ->where('period_type', 'daily')
        ->count();

        if ($dailySummariesCount > 0) {
            // Kunin ang unang record ng daily data
            $firstDaily = DB::table('expense_sums')
                ->where('period_type', 'daily')
                ->orderBy('start_date', 'asc')
                ->first();

            // Kunin ang pinakahuling record ng daily data
            $lastDaily = DB::table('expense_sums')
                ->where('period_type', 'daily')
                ->orderBy('start_date', 'desc')
                ->first();

            // Check kung magkaiba na ang buwan ng start_date ng una at huling daily record
            if (Carbon::parse($firstDaily->start_date)->format('Y-m') !== Carbon::parse($lastDaily->start_date)->format('Y-m')) {
                // Kunin ang lahat ng daily summaries
                $expenseSums = DB::table('expense_sums')
                    ->where('period_type', 'daily')
                    ->orderBy('start_date', 'asc')
                    ->get();

                // I-compute ang total amount ng daily summaries
                $totalMonthly = $expenseSums->sum('amount');
                $startDate = $expenseSums->first()->start_date;
                $endDate = $expenseSums->last()->end_date;

                // I-save ito bilang isang monthly summary
                DB::table('expense_sums')->insert([
                    'period_type' => 'monthly',
                    'amount' => $totalMonthly,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Burahin ang lahat ng daily summaries na naisama na sa monthly summary
                DB::table('expense_sums')
                    ->where('period_type', 'daily')
                    ->delete();
            }
        }

        // Tawagin ang computeProfit function para makuha ang profit
        $profit = $this->computeProfit();

        return redirect()->back()->with('success', 'Expenses finalized and summarized successfully.');

}

// Private function para sa pag-compute ng profit
private function computeProfit()
{
    // Hanapin ang huling monthly expense summary mula sa `expense_sums`
    $latestMonthlyExpense = DB::table('expense_sums')
        ->where('period_type', 'monthly')
        ->orderBy('start_date', 'desc')
        ->first();

    if (!$latestMonthlyExpense) {
        return 0; // Walang expenses, walang profit computation
    }

    // Kunin ang `start_date` at `end_date` ng huling monthly expense summary
    $startDate = $latestMonthlyExpense->start_date;
    $endDate = $latestMonthlyExpense->end_date;

    // Kunin ang total expenses para sa period na ito
    $monthlyExpenses = $latestMonthlyExpense->amount;

    // Kunin ang total sales para sa parehong period mula sa `historicals` table
    $monthlySales = DB::table('historicals')
        ->where('period_type', 'monthly')
        ->whereDate('start_date', $startDate)
        ->whereDate('end_date', $endDate)
        ->sum('total_sales');

    // I-compute ang profit
    $profit = $monthlySales - $monthlyExpenses;

    // Hanapin kung meron nang na-save na profit para sa parehong period
    $existingProfit = DB::table('profits')
        ->where('period_type', 'monthly')
        ->whereDate('start_date', $startDate)
        ->whereDate('end_date', $endDate)
        ->first();

    if (!$existingProfit) {
        // I-save ang computed profit sa `profits` table
        DB::table('profits')->insert([
            'period_type' => 'monthly',
            'amount' => $profit,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    } else {
        // I-update ang existing profit kung may bagong computation
        DB::table('profits')
            ->where('id', $existingProfit->id)
            ->update([
                'amount' => $profit,
                'updated_at' => now(),
            ]);
    }

    // Ibalik ang computed profit
    return $profit;
}

// Private function para pagsamahin ang mga duplicate na expenses
private function mergeDuplicateExpenses()
{
    // Kunin ang lahat ng records na naka-group ayon sa `start_date` at `end_date`
    $duplicates = DB::table('expense_sums')
        ->select('start_date', 'end_date', DB::raw('SUM(amount) as total_amount'), DB::raw('COUNT(id) as record_count'))
        ->groupBy('start_date', 'end_date')
        ->having('record_count', '>', 1)
        ->get();

    // I-loop ang bawat grupo ng duplicate records
    foreach ($duplicates as $duplicate) {
        // Kunin ang total amount para sa parehong dates
        $totalAmount = $duplicate->total_amount;
        $startDate = $duplicate->start_date;
        $endDate = $duplicate->end_date;

        // I-delete ang lahat ng records na may parehong `start_date` at `end_date`
        DB::table('expense_sums')
            ->where('start_date', $startDate)
            ->where('end_date', $endDate)
            ->delete();

        // Mag-insert ng isang record na may total amount
        DB::table('expense_sums')->insert([
            'period_type' => 'daily', // O 'monthly' kung applicable
            'amount' => $totalAmount,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

private function getAverageProfit()
{
    // Kunin ang average ng lahat ng profit mula sa `profits` table
    $averageProfit = DB::table('profits')
        ->where('period_type', 'monthly') // Kung gusto mo lang i-filter sa monthly profits
        ->avg('amount');

    return $averageProfit ?: 0; // Kung walang records, ibalik ang 0 bilang default
}

    /**
     * Get sales data for the chart based on the selected period.
     */
    public function salesChart(Request $request)
    {
        // Set the default period to 'monthly'
        $period = $request->input('period', 'monthly');

        // Kunin ang actual sales data
        $actualSales = Historical::where('period_type', 'monthly')
            ->orderBy('start_date', 'asc')
            ->get(['start_date', 'total_sales'])
            ->map(function ($data) {
                return [
                    'month' => \Carbon\Carbon::parse($data->start_date)->format('Y-m'),
                    'sales' => (float) $data->total_sales
                ];
            });

        // Kunin ang predicted sales
            $predictedSalesData = $this->getMonthlySalesDataForPrediction();
            $predictedSales = [];
            $startMonth = \Carbon\Carbon::now()->startOfMonth();
            if (!empty($predictedSalesData) && is_array($predictedSalesData)) {
                for ($i = 0; $i < count($predictedSalesData); $i++) {
                    $predictedSales[] = [
                        'month' => $startMonth->addMonth()->format('Y-m'),
                        'sales' => isset($predictedSalesData[$i]) ? $predictedSalesData[$i] : 0
                    ];
                }
            } else {
                for ($i = 0; $i < 12; $i++) {
                    $predictedSales[] = [
                        'month' => $startMonth->addMonth()->format('Y-m'),
                        'sales' => 0
                    ];
                }
            }

            $predictedStockData = $this->getMonthlyStockDataForPrediction();
            $predictedStocks = [];

            if (!empty($predictedStockData)) {
                foreach ($predictedStockData as $productName => $stockPredictions) {
                    if (isset($stockPredictions['error'])) {
                        $predictedStocks[] = [
                            'product' => $productName,
                            'error' => $stockPredictions['error'],
                        ];
                    } else {
                        foreach ($stockPredictions as $prediction) {
                            // Convert the month number to a month name (e.g., 'January', 'February', etc.)
                            $monthName = \Carbon\Carbon::parse($prediction['month'])->format('F-Y'); // 'F' gives full month name
                            $predictedStocks[] = [
                                'product' => $productName,
                                'month' => $monthName, // Use month name here
                                'predicted_quantity' => $prediction['predicted_quantity']
                            ];
                        }
                    }
                }
            } else {
                $predictedStocks[] = [
                    'product' => 'No data available',
                    'month' => now()->format('F-Y'), // Display the current month name
                    'predicted_quantity' => 0
                ];
            }





        // Kunin ang monthly expenses mula sa `expense_sums`
        $monthlyExpenses = Expense_sums::where('period_type', 'monthly')
            ->orderBy('start_date', 'asc')
            ->get(['start_date', 'amount'])
            ->map(function ($data) {
                return [
                    'month' => \Carbon\Carbon::parse($data->start_date)->format('Y-F'),
                    'amount' => (float) $data->amount
                ];
            });

        // Iba pang data
        $pendingOrders = Order::where('status', 0)->count();
        $products = Product::all();
        $stocks = $products->pluck('stock', 'product_Name');
        $totalExpensesToday = Expense::whereDate('created_at', Carbon::today())->sum('amount');
        $totalExpenses = Expense::sum('amount');
        $totalExpenses = Expense_sums::where('period_type', 'monthly')->avg('amount');
        $this->recordDailySales();
        $this->recordProductStocks();
        $profit = $this->computeProfit();
        $totalSalesToday = Payment::whereDate('purchase_date', Carbon::today())->sum('price');
        $totalSales = Payment::sum('price');
        $averageMonthlySales = Historical::where('period_type', 'monthly')->avg('total_sales');
        $averageProfit = $this->getAverageProfit();
        $hasData = !$actualSales->isEmpty() || !empty($predictedSalesData);
        $cancelledOrders = Order::where('status', 2)->count();

        $customerLocations = User::select('location', DB::raw('count(*) as count'))
            ->where('role', 'user')
            ->groupBy('location')
            ->orderByDesc('count')
            ->get();
        $locationLabels = $customerLocations->pluck('location');
        $locationCounts = $customerLocations->pluck('count');

        // Return sa view ang data
        return view('adminDash.dashboard', compact(
            'stocks',
            'totalSalesToday',
            'totalSales',
            'period',
            'profit',
            'pendingOrders',
            'totalExpensesToday',
            'totalExpenses',
            'averageMonthlySales',
            'actualSales',
            'predictedSales',
            'hasData',
            'locationLabels',
            'locationCounts',
            'monthlyExpenses',
            'cancelledOrders',
            'predictedStocks',
            'averageProfit'
        ));
    }



    private function recordDailySales()
{
    $yesterday = now()->subDay()->toDateString();
    $existingHistorical = Historical::whereDate('start_date', $yesterday)->where('period_type', 'daily')->first();

    if (!$existingHistorical) {
        // Calculate total sales for yesterday
        $yesterdaySales = Payment::whereDate('purchase_date', $yesterday)->sum('price');

        // Insert a new record in the historical table for daily sales
        Historical::create([
            'period_type' => 'daily',
            'start_date'  => $yesterday,
            'end_date'    => $yesterday,
            'total_sales' => $yesterdaySales,
            'is_processed' => false, // Default to false
        ]);
    }

    // Get the first 30 unprocessed daily records
    $dailySalesRecords = Historical::where('period_type', 'daily')->where('is_processed', false)
        ->orderBy('start_date', 'asc')->take(30)->get();

    // Check if we have exactly 30 records for processing
    if ($dailySalesRecords->count() == 30) {
        $monthlySalesTotal = $dailySalesRecords->sum('total_sales');
        $monthStartDate = $dailySalesRecords->first()->start_date;
        $monthEndDate = $dailySalesRecords->last()->start_date;

        // Create a new monthly record
        Historical::create([
            'period_type' => 'monthly',
            'start_date'  => $monthStartDate,
            'end_date'    => $monthEndDate,
            'total_sales' => $monthlySalesTotal,
        ]);

        // Mark these 30 records as processed
        $dailySalesRecords->each(function ($record) {
            $record->update(['is_processed' => true]);
        });
    }
}

private function recordProductStocks()
{
    $products = ['Container', 'Gallon', 'Water Bottle']; // Listahan ng mga produkto
    $yesterday = now()->subDay()->toDateString();

    foreach ($products as $product) {
        $existingHistorical = Stock::whereDate('start_date', $yesterday)
            ->where('period_type', 'daily')
            ->where('product_name', $product)
            ->first();

        if (!$existingHistorical) {
            // Calculate total stocks for the product as of yesterday
            $yesterdayStocks = Payment::where('product_Name', $product)->sum('quantity');

            // Insert a new record in the stocks table for daily records
            Stock::create([
                'period_type'   => 'daily',
                'product_name'  => $product,
                'quantity'      => $yesterdayStocks,
                'start_date'    => $yesterday,
                'end_date'      => $yesterday,
                'is_processed'  => false,
            ]);
        }

        // Get the first 30 unprocessed daily records for the product
        $dailyStockRecords = Stock::where('period_type', 'daily')
            ->where('product_name', $product)
            ->where('is_processed', false)
            ->orderBy('start_date', 'asc')
            ->take(30)
            ->get();

        // Check if we have exactly 30 records for processing
        if ($dailyStockRecords->count() == 30) {
            $monthlyStockTotal = $dailyStockRecords->sum('quantity');
            $monthStartDate = $dailyStockRecords->first()->start_date;
            $monthEndDate = $dailyStockRecords->last()->start_date;

            // Create a new monthly record
            Stock::create([
                'period_type'   => 'monthly',
                'product_name'  => $product,
                'quantity'      => $monthlyStockTotal,
                'start_date'    => $monthStartDate,
                'end_date'      => $monthEndDate,
                'is_processed'  => false, // Default to false for monthly
            ]);

            // Mark these daily records as processed
            $dailyStockRecords->each(function ($record) {
                $record->update(['is_processed' => true]);
            });
        }
    }
}




public function adminHistory(Request $request)
{
    // Kunin ang napiling petsa mula sa request
    $date = $request->input('date');

    // Kunin ang mga payment records na tugma sa napiling petsa
    $payments = Payment::when($date, function($query, $date) {
        return $query->whereDate('purchase_date', $date);
    })->get();

    // Kunin lamang ang mga order records na may status = 1 at tugma sa napiling petsa
    $orders = Order::when($date, function($query, $date) {
        return $query->whereDate('purchase_date', $date);
    })->where('status', 1)->get();

    // Ibalik ang view kasama ang parehong payments at orders
    return view('adminDash.history', compact('payments', 'orders'));
}

   private function getMonthlySalesDataForPrediction()
   {
       // Kunin ang historical sales data mula sa Historical table
       $salesData = Historical::where('period_type', 'monthly')
           ->orderBy('start_date', 'asc')
           ->distinct('start_date')
           ->get(['start_date', 'total_sales']);

       // I-prepare ang data para sa machine learning
       $samples = [];
       $targets = [];

       foreach ($salesData as $data) {
           $month = \Carbon\Carbon::parse($data->start_date)->month;
           $year = \Carbon\Carbon::parse($data->start_date)->year;
           $samples[] = [$year * 12 + $month]; // Convert year + month to a single value
           $targets[] = (float) $data->total_sales;
       }

       if (empty($samples)) {
           return ['error' => 'No sales data available for prediction.'];
       }

       // Ensure proper shape of the samples
       $samples = array_map(function($sample) {
           return is_array($sample) ? $sample : [$sample];
       }, $samples);

       // Train the linear regression model
       try {
           $regressor = new LeastSquares();
           $regressor->train($samples, $targets);
       } catch (\Exception $e) {
           return ['error' => 'Error in training the model: ' . $e->getMessage()];
       }

       // Pag-predict ng sales para sa susunod na 12 buwan (1 taon)
       $predictedSales = [];
       $currentMonth = (\Carbon\Carbon::now()->year * 12) + \Carbon\Carbon::now()->month;

       for ($i = 1; $i <= 5; $i++) {  // Mag-predict for 12 months
           $predictedSales[] = max(0, $regressor->predict([$currentMonth + $i]));
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
    private function getMonthlyStockDataForPrediction()
    {
        // Kunin ang historical stock data mula sa Stocks table
        $stockData = Stock::where('period_type', 'monthly')
            ->orderBy('start_date', 'asc')
            ->distinct('start_date')
            ->get(['start_date', 'quantity', 'product_name']);

        // I-prepare ang data para sa machine learning
        $samples = [];
        $targets = [];
        $productNames = [];

        foreach ($stockData as $data) {
            $month = \Carbon\Carbon::parse($data->start_date)->month;
            $year = \Carbon\Carbon::parse($data->start_date)->year;

            $samples[] = [$year * 12 + $month]; // Convert year + month to a single value
            $targets[] = (float) $data->quantity;
            $productNames[$data->product_name][] = [$year * 12 + $month, (float) $data->quantity];
        }

        // Kung walang stock data, ibalik ang empty array na may error na string sa loob
        if (empty($samples)) {
            return []; // Return empty array, not string
        }

        // I-train ang linear regression model para sa bawat produkto
        $predictedStocks = [];
        foreach ($productNames as $productName => $data) {
            $samples = array_column($data, 0);
            $targets = array_column($data, 1);

            try {
                $regressor = new LeastSquares();
                $regressor->train(array_map(fn($s) => [$s], $samples), $targets);

                // Pag-predict ng stocks para sa susunod na limang buwan
                $currentMonth = (\Carbon\Carbon::now()->year * 12) + \Carbon\Carbon::now()->month;
                $productPredictions = [];
                for ($i = 1; $i <= 5; $i++) {
                    $predictedQuantity = max(0, $regressor->predict([$currentMonth + $i]));
                    $productPredictions[] = [
                        'month' => \Carbon\Carbon::now()->addMonths($i)->format('Y-m'),
                        'predicted_quantity' => round($predictedQuantity, 2),
                    ];
                }

                $predictedStocks[$productName] = $productPredictions;
            } catch (\Exception $e) {
                // Kung may error sa training, mag-return ng error message
                $predictedStocks[$productName] = ['error' => 'Error in training the model: ' . $e->getMessage()];
            }
        }

        return $predictedStocks;
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
