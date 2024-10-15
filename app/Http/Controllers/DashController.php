<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // Import Carbon for date handling

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

         // Total sales for today
         $totalSalesToday = Payment::whereDate('purchase_date', Carbon::today())->sum('price');

         // Total sales overall
         $totalSales = Payment::sum('price');

         // Sales data for charting
         $salesData = Payment::select(DB::raw('DATE(purchase_date) as date, SUM(price) as total_sales'))
             ->groupBy('date')
             ->orderBy('date', 'asc')
             ->get();

         // Get the selected period (default to 'weekly')
         $period = $request->input('period', 'weekly');

         // Return the view with the required data
         return view('adminDash.dashboard', compact('totalSalesToday', 'totalSales', 'salesData', 'period'));
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
