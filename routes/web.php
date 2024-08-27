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

    Route::get('/purchase/create', [PaymentController::class, 'create'])->name('payment');
    Route::post('/purchase', [PaymentController::class, 'buy'])->name('payment');
});




