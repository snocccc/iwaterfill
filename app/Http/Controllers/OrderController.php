<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Payment;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   // OrderController.php


    public function userhistory()
       {
       // Kunin ang authenticated na user ID
    $userId = Auth::id();

    // Hanapin ang lahat ng transactions na nauugnay sa user ID
    $orders = Order::where('order_id', $userId)->get();

    // Ibalik ang view kasama ang transactions
    return view('userDash.userHistory', compact('orders'));
        }

        public function userOrder()
        {
            // Kunin ang lahat ng products mula sa database
            $products = Product::all();

            // Ibalik ang view para sa payment form kasama ang products
            return view('userDash.userOrder', compact('products'));
        }

        public function userBuy(Request $request)
{
    // Validate the incoming request data for users
    $validated = $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
    ]);
    // Retrieve the product based on the selected product_id
    $product = Product::findOrFail($validated['product_id']);

    // Get the authenticated user's username
    $username = Auth::user()->username;
    $location = Auth::user()->location;
    $phone = Auth::user()->phone;

     // Get the authenticated user's ID
     $orderId = Auth::id();
    // Create a new Order record for user purchases
    Order::create([
        'order_id' => $orderId,
        'username' => $username,
        'product_Name' => $product->product_Name,
        'quantity' => $validated['quantity'],
        'price' => $product->price * $validated['quantity'],
        'location' => $location,
        'phone' => $phone,
        'image_url' => $product->image_url,
        'purchase_date' => now(),
        'status' => false, // Default status is false
    ]);

    // Redirect back with a success message
    return redirect()->route('userOrder')->with('success', 'Order completed successfully.');
}

    // Display all pending orders
    public function pendingOrders()
    {
        // Kunin lahat ng orders na may status = false (pending)
        $orders = Order::where('status', false)->get();

        // Ibalik ang view kasama ang mga pending orders
        return view('adminDash.order', compact('orders'));
    }

    public function placeOrder(Request $request)
{
    // Kunin ang order gamit ang ID mula sa request
    $order = Order::findOrFail($request->order_id);

    // I-update ang status ng order sa true (success)
    $order->status = true;
    $order->save();

    // Hanapin ang produkto gamit ang pangalan ng produkto
    $product = Product::where('product_Name', $order->product_Name)->first();

    // Siguraduhin na ang produkto ay matatagpuan
    if ($product) {
        // Bawasan ang stock ng produkto batay sa quantity ng order
        $product->stock -= $order->quantity;

        // I-save ang mga pagbabago sa produkto
        $product->save();
    } else {
        // Kung walang produkto na natagpuan, magbigay ng error
        return redirect()->back()->with('error', 'Product not found!');
    }

    // Kapag successful ang pag-save ng status, i-save rin sa Payment table
    Payment::create([
        'username'      => $order->username,
        'product_Name'  => $order->product_Name,
        'quantity'      => $order->quantity,
        'price'         => $order->price,
        'purchase_date' => now(), // Itinatala ang kasalukuyang date/time ng purchase
    ]);

    // I-redirect pabalik sa pending orders na may success message
    return redirect()->back()->with('message', 'Order placed and saved to payment successfully!');
}

public function completedOrders()
{
    // Kunin ang lahat ng orders na may status na 1
    $completedOrders = Order::where('status', 1)->get();

    // Ibalik ang view na nagpapakita ng mga natapos na order
    return view('adminDash.completedOrder', compact('completedOrders'));
}

public function cancel($id)
{
    // Hanapin ang order gamit ang ID
    $order = Order::find($id);

    // Suriin kung may order
    if (!$order) {
        return redirect()->back()->with('error', 'Order not found.');
    }

    // Siguraduhing nasa "pending" status (0) bago i-cancel
    if ($order->status != 0) {
        return redirect()->back()->with('error', 'Only pending orders can be canceled.');
    }

    // I-update ang status bilang "canceled" (gamit natin ang 2 bilang example para sa canceled)
    $order->status = 2; // Ang 2 ay maaaring mag-represent ng "canceled"
    $order->save();

    return redirect()->back()->with('success', 'Order has been canceled successfully.');
}
public function getCancelledOrders()
{
    // Retrieve all orders where status is 2
    $cancelledOrders = Order::where('status', 2)->get();

    // Pass the data to the view
    return view('adminDash.cancelledOrder2', compact('cancelledOrders'));
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
    public function store(Request $request)
    {
        //
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
