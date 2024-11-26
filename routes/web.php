<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\DashController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Guest Routes (for users who are not authenticated)
Route::middleware('guest')->group(function() {
    // Authentication
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [UserController::class, 'login']);

    // Registration
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [UserController::class, 'register']);
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');
    Route::get('/password/reset/success', [ForgotPasswordController::class, 'resetSuccess'])->name('password.reset.success');



});

// Authenticated Routes (for logged-in users)
Route::middleware('auth')->group(function() {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    Route::middleware(['role:user'])->group(function () {
    Route::get('/customer/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/user/pending-orders', [ProfileController::class, 'userPending'])->name('user.pendingOrders');
    Route::delete('/order/cancel/{id}', [OrderController::class, 'cancelOrder'])->name('order.cancel');
    Route::get('/user/completed-orders', [ProfileController::class, 'userCompleted'])->name('user.completedOrders');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::view('profile/update-password', 'userDash.changePass')->name('profile.updatePassword');
    Route::get('/userOrder', [OrderController::class, 'userOrder'])->name('userOrder');
    Route::post('/buying', [OrderController::class, 'userBuy'])->name('userBuy');
    Route::get('/userhistory', [OrderController::class, 'userhistory'])->name('userHistory');
    });


    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [DashController::class, 'salesChart'])->name('dashboard');
        Route::post('/admin/dashboard', [DashController::class, 'testHistoricalData'])->name('addd');

        // Payments and Purchase
       Route::get('/AddPurchase', [PaymentController::class, 'purchase'])->name('purchase');
       Route::post('/AddPurchase', [PaymentController::class, 'buy'])->name('buy');
       // Orders
       Route::get('/orders/pending', [OrderController::class, 'pendingOrders'])->name('order');
       Route::post('/orders/place', [OrderController::class, 'placeOrder'])->name('placeOrder');
       Route::get('/admin/completed-orders', [OrderController::class, 'completedOrders'])->name('completed.orders');

       Route::post('/update-expense', [DashController::class, 'updateExpense'])->name('update');
       Route::post('/finalize-expenses', [DashController::class, 'finalizeExpenses'])->name('finalize');

        // Customer List
       Route::get('/customerList', [DashController::class, 'customerList'])->name('customerList');
       // Products Management
       Route::view('/addProduct', 'adminDash.addProduct')->name('addProduct');
       Route::post('/addProduct', [ProductController::class, 'add']);
       // Update Products
       Route::post('/update-products', [ProductController::class, 'updateProducts'])->name('updateProducts');
       // Payment History and Editing
       Route::get('/history', [DashController::class, 'adminHistory'])->name('history');
       Route::get('/payments/{id}/edit', [PaymentController::class, 'edit'])->name('payments.edit');
       Route::put('/payments/{id}', [PaymentController::class, 'update'])->name('payments.update');
       Route::delete('/payments/{id}', [PaymentController::class, 'destroy'])->name('payments.destroy');
       // Containers Management
       Route::get('/container', [ProductController::class, 'showContainers'])->name('container');
       // Route para sa pag-edit ng stock ng produkto
       Route::post('/update-product-stock', [ProductController::class, 'updateStock'])->name('updateProducts');

       Route::post('/borrow-container', [ProductController::class, 'borrowContainer'])->name('borrowContainer');
       Route::post('/return-container', [ProductController::class, 'returnContainer'])->name('returnContainer');

       Route::get('/admin-settings', [ProfileController::class, 'adminSetting'])->name('settings');
       Route::post('/add-backup-account', [UserController::class, 'storeBackupAccount'])->name('backup.store');
       Route::post('/profile/admin-update-password', [ProfileController::class, 'adminUpdatepass'])->name('admin.updatePassword');
       Route::view('profile/admin-update-password', 'adminDash.changePass')->name('adminUpdatepass');
    });

});
