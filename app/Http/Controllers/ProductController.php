<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function add(Request $request)
    {
        // Create a new product and save it to the database
        $product = Product::create([
            'product_Name' => $request->input('product-name'),
            'description' => $request->input('product-description'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'availableCon' => $request->input('stock'),
        ]);

         // Flash success message
    session()->flash('success', 'Product successfully added!');

    // Redirect back to the form or to another page
    return redirect()->route('addProduct');

        // Redirect to the dashboard or any other view
        return view('users.dashboard');
    }
    // ProductController.php

    public function showContainers()
    {
        // Kunin ang mga produkto na may pangalan na "Big Container" o "Container"
        $containers = Product::whereIn('product_Name', ['Galoon', 'Container'])->get();

        // Kunin ang lahat ng mga produkto
        $allProducts = Product::all();

        // Ibalik ang view na may compact ng containers at allProducts
        return view('adminDash.container', compact('containers', 'allProducts'));
    }

    public function updateStock(Request $request)
{
    // Kunin ang mga updated na stock mula sa form
    $updatedStocks = $request->input('stock');

    // I-update ang stock para sa bawat produkto
    foreach ($updatedStocks as $productId => $stock) {
        $product = Product::find($productId);
        if ($product) {
            // I-update ang stock ng produkto
            $product->stock = $stock;
            $product->save();
        }
    }

    // Magbalik ng success message at i-redirect
    return redirect()->back()->with('success', 'Stocks updated successfully!');
}



public function borrowContainer(Request $request)
{
    // Hanapin ang product base sa input
    $product = Product::where('product_Name', $request->input('product_name'))->first();

    // Kumuha ng dami na ibo-borrow mula sa request
    $borrowQuantity = $request->input('borrow_quantity');

    // Check kung may sapat na stock
    if ($product && $product->availableCon >= $borrowQuantity) {
        // Bawasan ang stock
        $product->availableCon -= $borrowQuantity;
        $product->save(); // I-save ang pagbabago sa database

        return redirect()->back()->with('success', 'Container borrowed successfully!');
    }

    return redirect()->back()->with('error', 'Not enough stock available.');
}
public function returnContainer(Request $request)
{
    // Hanapin ang product base sa input
    $product = Product::where('product_Name', $request->input('return_product_name'))->first();

    // Kumuha ng dami na ibo-borrow mula sa request
    $returnQuantity = $request->input('return_quantity');

    // Check kung may valid na product at kung hindi ito nagiging negative
    if ($product) {
        // Dagdagan ang available containers
        $product->availableCon += $returnQuantity;
        $product->save(); // I-save ang pagbabago sa database

        return redirect()->back()->with('success', 'Container returned successfully!');
    }

    return redirect()->back()->with('error', 'Container not found.');
}

    // ProductController.php
public function updateProducts(Request $request)
{
    // Loop through each product and update its stock
    foreach ($request->input('stock') as $productId => $newStock) {
        $product = Product::findOrFail($productId); // Find the product by ID
        $product->stock = $newStock; // Update the stock value
        $product->save(); // Save the updated product
    }

    // Redirect back with a success message
    return redirect()->back()->with('success', 'Product quantities updated successfully.');
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
