<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
    public function buy(Request $request)
    {
       // Validate the incoming request data
    $validated = $request->validate([
        'customer_name' => 'required|string|max:255',
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
        'price' => 'required|numeric',
        'purchase_date' => 'required|string', // Validate as string instead of date
    ]);

    // Parse the purchase_date using Carbon
    $purchaseDate = Carbon::createFromFormat('F j, Y H:i', $validated['purchase_date']);

    // Retrieve the product based on the selected product_id
    $product = Product::findOrFail($validated['product_id']);

    // Create a new Payment record
    Payment::create([
        'customer_Name' => $validated['customer_name'],
        'product_Name' => $product->product_Name,
        'quantity' => $validated['quantity'],
        'price' => $validated['price'],
        'purchase_date' => $purchaseDate, // Use the formatted date
    ]);

    // Redirect back with a success message
    return redirect()->route('purchase')->with('success', 'Purchase completed successfully.');
    }

    public function index(Request $request)
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
