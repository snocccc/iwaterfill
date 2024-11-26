<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

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
