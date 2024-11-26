<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Expense_sums;
use App\Models\Historical;
use App\Models\User;
use App\Models\Payment;
use App\Models\Order;
use App\Models\Product;
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
        // Retrieve all users from the database
        $users = User::all();

        // Pass the users to the view
        return view('adminDash.customerList', ['users' => $users]);
    }


    // Method para mag-update ng expense
public function updateExpense(Request $request)
{
    $request->validate([
        'amount' => 'required|numeric|min:0',
        'description' => 'required|string|max:255',
    ]);

    // Insert a new expense record sa database
    Expense::create([
        'period_type' => 'monthly', // Maaari mong baguhin ito depende sa kailangan mo (e.g., 'daily', 'weekly', 'monthly')
        'description' => $request->input('description'),
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

    /**
     * Get sales data for the chart based on the selected period.
     */
    public function salesChart(Request $request)
    {
        // Set the default period to 'monthly'
        $period = $request->input('period', 'monthly');

        // Kunin ang historical sales data mula sa Historical table
        $actualSales = Historical::where('period_type', 'monthly')
            ->orderBy('start_date', 'asc')
            ->get(['start_date', 'total_sales'])
            ->map(function ($data) {
                return [
                    'month' => \Carbon\Carbon::parse($data->start_date)->format('Y-m'),
                    'sales' => (float) $data->total_sales
                ];
            });

        // Kunin ang predicted sales gamit ang private function
$predictedSalesData = $this->getMonthlySalesDataForPrediction();

// Pag-format ng predicted sales data
$predictedSales = [];
$startMonth = \Carbon\Carbon::now()->startOfMonth();

// Mag-check muna kung may laman ang $predictedSalesData
if (!empty($predictedSalesData) && is_array($predictedSalesData)) {
    for ($i = 0; $i < count($predictedSalesData); $i++) {
        $predictedSales[] = [
            'month' => $startMonth->addMonth()->format('Y-m'),
            'sales' => isset($predictedSalesData[$i]) ? $predictedSalesData[$i] : 0 // Default sa 0 kung wala
        ];
    }
} else {
    // Kapag walang laman, lagyan ng default na mensahe o 0 data
    for ($i = 0; $i < 12; $i++) {
        $predictedSales[] = [
            'month' => $startMonth->addMonth()->format('Y-m'),
            'sales' => 0 // Default value kapag walang data
        ];
    }
}


 // Get all orders where the status is 0 (pending orders)
 $pendingOrders = Order::where('status', 0)->count();
        // Ihanda ang iba pang data para sa view
        $products = Product::all();
        $stocks = $products->pluck('stock', 'product_Name');

         // Kunin ang kabuuang halaga ng expenses ngayon
         $totalExpensesToday = Expense::whereDate('created_at', Carbon::today())->sum('amount');
         $totalExpenses = Expense::sum('amount');
         $totalExpenses = Expense_sums::where('period_type', 'monthly')->avg('amount');

        $this->recordDailySales();
         // Tawagin ang computeProfit function para makuha ang profit
         $profit = $this->computeProfit();

        $totalSalesToday = Payment::whereDate('purchase_date', Carbon::today())->sum('price');
        $totalSales = Payment::sum('price');

        $averageDailySales = Historical::where('period_type', 'daily')->avg('total_sales');
        $averageMonthlySales = Historical::where('period_type', 'monthly')->avg('total_sales');

        // Check kung may laman ang data
        $hasData = !$actualSales->isEmpty() || !empty($predictedSalesData);

        $customerLocations = User::select('location', DB::raw('count(*) as count'))
    ->where('role', 'user') // I-filter ang mga may role na 'user' lamang
    ->groupBy('location')
    ->orderByDesc('count')
    ->get();

         // I-format ang data para sa chart
        $locationLabels = $customerLocations->pluck('location');
        $locationCounts = $customerLocations->pluck('count');

        return view('adminDash.dashboard', compact(
            'stocks',
            'totalSalesToday',
            'totalSales',
            'period',
            'profit',
            'pendingOrders',
            'totalExpensesToday',
            'totalExpenses',
            'averageDailySales',
            'averageMonthlySales',
            'actualSales',
            'predictedSales',
            'hasData',
            'locationLabels', // Idagdag ang labels ng location
            'locationCounts',// Flag na magsasabi kung may data o wala
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
