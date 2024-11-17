<?php

namespace App\Http\Controllers;

use App\Models\Historical;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function purchase()
    {
        $products = Product::all(); // Retrieve all products
        return view('adminDash.purchase', ['products' => $products]);
    }

    /**
     * Handle the form submission and save the payment.
     */
    // Buy method remains the same
public function buy(Request $request)
{
    // Validate the incoming request data
    $validated = $request->validate([
        'username'   => 'required|string|max:255',
        'product_id' => 'required|exists:products,id',
        'quantity'   => 'required|integer|min:1',
    ]);

    // Retrieve the product based on product_id
    $product = Product::findOrFail($validated['product_id']);

    // Compute the total price
    $totalPrice = $product->price * $validated['quantity'];

    // Ensure stock availability
    if ($validated['quantity'] > $product->stock) {
        return redirect()->route('purchase')->with('error', 'Insufficient stock for this product.');
    }

    // Call the private function to handle daily and weekly sales logic
    $this->recordDailySales();

    // Create a new Payment record
    Payment::create([
        'username'      => $validated['username'],
        'product_Name'  => $product->product_Name,
        'quantity'      => $validated['quantity'],
        'price'         => $totalPrice,
        'purchase_date' => now(),
    ]);

    // Update product stock
    $product->decrement('stock', $validated['quantity']);

    // Redirect with a success message
    return redirect()->route('purchase')->with('success', 'Purchase completed successfully.');
}

// Private function to record daily and weekly sales
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
        ]);
    }

    // Check if there are 7 daily sales records
    $dailySalesRecords = Historical::where('period_type', 'daily')->orderBy('start_date', 'asc')->take(7)->get();

    if ($dailySalesRecords->count() == 7) {
        // Calculate total sales for the week
        $weeklySalesTotal = $dailySalesRecords->sum('total_sales');
        $weekStartDate = $dailySalesRecords->first()->start_date;
        $weekEndDate = $dailySalesRecords->last()->start_date;

        // Insert a new record in the historical table for weekly sales
        Historical::create([
            'period_type' => 'weekly',
            'start_date'  => $weekStartDate,
            'end_date'    => $weekEndDate,
            'total_sales' => $weeklySalesTotal,
        ]);

        // // Delete the 7 daily records that have been summed up into weekly sales
        // Historical::whereIn('id', $dailySalesRecords->pluck('id'))->delete();
    }

    // Check if there are 7 daily sales records
    $dailySalesRecords = Historical::where('period_type', 'daily')->orderBy('start_date', 'asc')->take(30)->get();

    if ($dailySalesRecords->count() ==30) {
        $monthlySalesTotal = $dailySalesRecords->sum('total_sales');
        $monthStartDate = $dailySalesRecords->first()->start_date;
        $monthEndDate = $dailySalesRecords->last()->start_date;

        Historical::create([
            'period_type' => 'monthly',
            'start_date'  => $monthStartDate,
            'end_date'    => $monthEndDate,
            'total_sales' => $monthlySalesTotal,
        ]);
    }
}

    public function adminHistory(Request $request)
   {
    // Kunin ang napiling petsa mula sa request
    $date = $request->input('date');

    // Kung may napiling petsa, mag-query lamang ng mga records na tumutugma sa petsa na iyon
    $payments = Payment::when($date, function($query, $date) {
        return $query->whereDate('purchase_date', $date);
    })->get();

    // Ibalik ang view kasama ang na-filter na records
    return view('adminDash.history', compact('payments'));
   }

//    public function getSalesData(Request $request) {
//       // Actual sales ngayong araw
//       $totalSalesToday = Payment::whereDate('purchase_date', Carbon::today())->sum('price');

//       // Total sales sa lahat ng panahon
//       $totalSales = Payment::sum('price');

//       // Forecasted sales: Kunin ang average ng nakaraang tatlong buwan
//       $forecastedSales = Payment::whereBetween('purchase_date', [
//               now()->subMonths(3)->startOfMonth(), now()->endOfMonth()
//           ])
//           ->select(DB::raw('SUM(price) / 3 as avg_sales')) // Average sa 3 buwan
//           ->value('avg_sales');

//       // Ibalik ang view kasama ang mga sales data
//       return view('adminDash.dashboard', compact('totalSalesToday', 'totalSales', 'forecastedSales'));
// }

   // Override the authenticated method

//    public function userhistory()
//    {
//        // Kunin ang authenticated na user at pangalan niya
//         $username = Auth::user()->username;

//         // Hanapin ang lahat ng transactions na may parehong customer name
//         $payments = Payment::where('username', $username)->get();

//         // Ibalik ang view kasama ang transactions
//         return view('userDash.userHistory', compact('payments'));
//     }

//     public function userPayment()
//     {
//         // Kunin ang lahat ng products mula sa database
//         $products = Product::all();

//         // Ibalik ang view para sa payment form kasama ang products
//         return view('userDash.userPurchase', compact('products'));
//     }

//     public function userBuy(Request $request)
// {
//     // Validate the incoming request data for users
//     $validated = $request->validate([
//         'product_id' => 'required|exists:products,id',
//         'quantity' => 'required|integer|min:1',
//         'purchase_date' => 'required|string', // Validate as string instead of date
//     ]);

//     // Parse the purchase_date using Carbon
//     $purchaseDate = Carbon::createFromFormat('F j, Y H:i', $validated['purchase_date']);

//     // Retrieve the product based on the selected product_id
//     $product = Product::findOrFail($validated['product_id']);

//     // Get the authenticated user's username
//     $username = Auth::user()->username; // Palitan ito kung ang 'name' ay nananatili

//     // Create a new Payment record for user purchases
//     Payment::create([
//         'username' => $username, // Gumamit ng 'username' dito
//         'product_Name' => $product->product_Name,
//         'quantity' => $validated['quantity'], // Add quantity here
//         'price' => $product->price * $validated['quantity'], // Calculate total price
//         'purchase_date' => $purchaseDate, // Use the formatted date
//     ]);

//     // Redirect back with a success message
//     return redirect()->route('userPayment')->with('success', 'Purchase completed successfully.');
// }






    //






    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $payment = Payment::findOrFail($id);
    return view('payments.edit', compact('payment')); // Palitan ang 'payments.edit' sa tamang view file
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'customer_Name' => 'required|string|max:255',
            'product_Name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1', // Corrected syntax here
            'price' => 'required|numeric',
            'purchase_date' => 'required|date',
        ]);


        $payment = Payment::findOrFail($id);
        $payment->update($request->all());

        return redirect()->route('history')->with('success', 'Payment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

    return redirect()->route('history')->with('success', 'Payment deleted successfully.');

    }
}
