<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function buy(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'product_id' => 'required|exists:products,id',
            'price' => 'required|numeric',
            'purchase_date' => 'required|date',
        ]);

        // Retrieve the product based on the selected product_id
        $products = Product::findOrFail($validated['product_id']);

        // Create a new Payment record
        $payment = Payment::create([
            'customer_Name' => $validated['customer_name'],
            'product_Name' => $products->product_Name, // Assuming you want to store the product name
            'price' => $validated['price'],
            'purchase_date' => $validated['purchase_date'],
        ]);

        // Redirect back to a specific view or route with a success message
        return redirect()->route('payment')->with('success', 'Purchase completed successfully.');
    }





    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         // Fetch all products from the database
         $products = Product::all();

         // Pass the products to the view
         return view('users.dashboard', compact('products'));

    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
