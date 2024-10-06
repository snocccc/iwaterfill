<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validate input
        $fields = $request->validate([
            'username' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'email', 'unique:customers,email'],
            'location' => ['required', 'max:50'],
            'phone' => ['required'],
            'password' => ['required', 'min:3', 'confirmed']
        ]);



        // Register the customer
        $customer = Customer::create($fields);

        Auth::login($customer);
    }

    public function login(Request $request) {
        // Validate
        $fields = $request->validate([
            'email' => ['required', 'email', 'max:50'], // Palitan ang 'username' ng 'email'
            'password' => ['required']
        ]);

        // Attempt to log in with the provided credentials
        if (Auth::attempt($fields, $request->filled('remember'))) {
            // Authentication passed, redirect to the intended page or home
            return redirect()->intended('dashboard'); // Palitan ang 'dashboard' sa iyong intended route
        }

        // Authentication failed, redirect back with an error
        return back()->withErrors([
            'failed' => 'The provided credentials do not match our records.',
        ]);
    }

    }
