<?php

namespace App\Http\Controllers;

use App\Models\Historical;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function updateSalesSummary()
    // {
    //     // Calculate weekly sales
    //     $startOfWeek = Carbon::now()->startOfWeek();
    //     $endOfWeek = Carbon::now()->endOfWeek();
    //     $totalWeeklySales = Payment::whereBetween('purchase_date', [$startOfWeek, $endOfWeek])->sum('price');

    //     Historical::updateOrCreate(
    //         ['period_type' => 'weekly', 'start_date' => $startOfWeek, 'end_date' => $endOfWeek],
    //         ['total_sales' => $totalWeeklySales]
    //     );

    //     // Calculate monthly sales
    //     $startOfMonth = Carbon::now()->startOfMonth();
    //     $endOfMonth = Carbon::now()->endOfMonth();
    //     $totalMonthlySales = Payment::whereBetween('purchase_date', [$startOfMonth, $endOfMonth])->sum('price');

    //     Historical::updateOrCreate(
    //         ['period_type' => 'monthly', 'start_date' => $startOfMonth, 'end_date' => $endOfMonth],
    //         ['total_sales' => $totalMonthlySales]
    //     );

    //     return "Sales summary updated successfully.";
    // }

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
