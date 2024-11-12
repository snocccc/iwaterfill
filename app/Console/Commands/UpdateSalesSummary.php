<?php

namespace App\Console\Commands;

use App\Models\Historical;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Console\Command;

// class UpdateSalesSummary extends Command
// {
//     // protected $signature = 'sales:update-summary';
//     // protected $description = 'Calculate and update the weekly and monthly total sales in the sales_summary table';

//     // public function handle()
//     // {
//     //     // Calculate weekly sales
//     //     $startOfWeek = Carbon::now()->startOfWeek();
//     //     $endOfWeek = Carbon::now()->endOfWeek();
//     //     $totalWeeklySales = Payment::whereBetween('purchase_date', [$startOfWeek, $endOfWeek])->sum('price');

//     //     Historical::updateOrCreate(
//     //         ['period_type' => 'weekly', 'start_date' => $startOfWeek, 'end_date' => $endOfWeek],
//     //         ['total_sales' => $totalWeeklySales]
//     //     );

//     //     // Calculate monthly sales
//     //     $startOfMonth = Carbon::now()->startOfMonth();
//     //     $endOfMonth = Carbon::now()->endOfMonth();
//     //     $totalMonthlySales = Payment::whereBetween('purchase_date', [$startOfMonth, $endOfMonth])->sum('price');

//     //     Historical::updateOrCreate(
//     //         ['period_type' => 'monthly', 'start_date' => $startOfMonth, 'end_date' => $endOfMonth],
//     //         ['total_sales' => $totalMonthlySales]
//     //     );

//     //     $this->info('Sales summary updated successfully.');
//     // }

// }
