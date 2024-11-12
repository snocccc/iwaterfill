<?php

use App\Http\Controllers\DashController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalesController;
use Illuminate\Support\Facades\Route;

// Guest Routes (for users who are not authenticated)
Route::middleware('guest')->group(function() {
    // Authentication
    Route::view('/', 'auth.login')->name('login');
    Route::post('/', [UserController::class, 'login']);

    // Registration
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [UserController::class, 'register']);

    // Congratulations page after registration
    Route::view('/congratulations', 'auth.afterRegister')->name('afterRegister');

});

// Authenticated Routes (for logged-in users)
Route::middleware('auth')->group(function() {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');



    Route::middleware(['role:user'])->group(function () {

        // Route para sa customer profile
    Route::get('/customer/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::view('profile/update-password', 'userDash.changePass')->name('profile.updatePassword');






    Route::get('/userOrder', [OrderController::class, 'userOrder'])->name('userOrder');
    Route::post('/buying', [OrderController::class, 'userBuy'])->name('userBuy');

    // Payment History and Editing
    Route::get('/userhistory', [OrderController::class, 'userhistory'])->name('userHistory');
     // Logout


    });


    // Admin Routes (only for users with 'admin' role)
    Route::middleware(['role:admin'])->group(function () {

        Route::get('/admin/dashboard', [DashController::class, 'salesChart'])->name('dashboard');

        // Payments and Purchase
       Route::get('/AddPurchase', [PaymentController::class, 'purchase'])->name('purchase');
       Route::post('/AddPurchase', [PaymentController::class, 'buy'])->name('buy');
       // Orders
       Route::get('/orders/pending', [OrderController::class, 'pendingOrders'])->name('order');
       Route::post('/orders/place', [OrderController::class, 'placeOrder'])->name('placeOrder');
    //    Route::get('/test-sales-summary', [SalesController::class, 'updateSalesSummary']);



        // Customer List
       Route::get('/customerList', [DashController::class, 'customerList'])->name('customerList');
       // Products Management
       Route::view('/addProduct', 'adminDash.addProduct')->name('addProduct');
       Route::post('/addProduct', [ProductController::class, 'add']);
       // Update Products
       Route::post('/update-products', [ProductController::class, 'updateProducts'])->name('updateProducts');
       // Payment History and Editing
       Route::get('/history', [PaymentController::class, 'adminHistory'])->name('history');
       Route::get('/payments/{id}/edit', [PaymentController::class, 'edit'])->name('payments.edit');
       Route::put('/payments/{id}', [PaymentController::class, 'update'])->name('payments.update');
       Route::delete('/payments/{id}', [PaymentController::class, 'destroy'])->name('payments.destroy');
       // Containers Management
       Route::get('/container', [ProductController::class, 'showContainers'])->name('container');
       // Route para sa pag-edit ng stock ng produkto
       Route::post('/update-product-stock', [ProductController::class, 'updateStock'])->name('updateProducts');

       Route::post('/borrow-container', [ProductController::class, 'borrowContainer'])->name('borrowContainer');
       Route::post('/return-container', [ProductController::class, 'returnContainer'])->name('returnContainer');
        // Logout
    });
});
