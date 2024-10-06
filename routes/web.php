<?php

use App\Http\Controllers\DashController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;



Route::middleware('guest')->group(function() {

    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [UserController::class, 'login']);

    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [UserController::class, 'register']);
});

Route::middleware('auth')->group(function() {

    Route::view('/congratulations', 'auth.afterRegister')->name('afterRegister');
    Route::get('/dashboard', [DashController::class, 'login'])->name('dashboard');
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    Route::view('/addProduct', 'adminDash.addProduct')->name('addProduct');
    Route::post('/addProduct', [ProductController::class, 'add']);

    Route::get('/customerList', [DashController::class, 'customerList'])->name('customerList');


    // Route to display the purchase form
    Route::get('/AddPurchase', [PaymentController::class, 'purchase'])->name('purchase');

    // Route to handle the form submission
    Route::post('/AddPurchase', [PaymentController::class, 'buy'])->name('buy');

    Route::get('/history', [PaymentController::class, 'index'])->name('history');
    // Route para sa pag-edit ng payment

    Route::get('/payments/{id}/edit', [PaymentController::class, 'edit'])->name('payments.edit');
    // Route para sa pag-update ng payment
    Route::put('/payments/{id}', [PaymentController::class, 'update'])->name('payments.update');
    // Route para sa pag-delete ng payment
    Route::delete('/payments/{id}', [PaymentController::class, 'destroy'])->name('payments.destroy');

    Route::get('/dashboard', [DashController::class, 'salesChart'])->name('dashboard');

    // web.php

    Route::get('/container', [ProductController::class, 'showContainers'])->name('container');
    // web.php
    Route::post('/update-products', [ProductController::class, 'updateProducts'])->name('updateProducts');


    Route::post('/borrow-container', [ProductController::class, 'borrowContainer'])->name('borrowContainer');
    Route::post('/return-container', [ProductController::class, 'returnContainer'])->name('returnContainer');




    // // Route para sa pagkuha ng containers
    // Route::get('/containers', [ProductController::class, 'getContainers'])->name('containers.get');
    // // Route para sa paghiram ng container
    // Route::post('/borrow-container', [ProductController::class, 'borrowContainer'])->name('containers.borrow');
    // // Route para sa pagbabalik ng container
    // Route::post('/return-container', [ProductController::class, 'returnContainer'])->name('containers.return');

    // Route para sa pagkuha ng available containers

    // Route::get('/available-containers', [ProductController::class, 'getAvailableContainers'])->name('availableContainer');




});




