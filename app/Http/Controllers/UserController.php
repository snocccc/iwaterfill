<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function register(Request $request)
    {
        //validate input
        $fields = $request->validate([
            'username' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'email', 'unique:users,email'],
            'location' => ['required', 'max:50'],
            'phone' => ['required', 'min:11'],
            'password' => ['required', 'min:6', 'confirmed']
        ]);

        //Register the user
        $user = User::create($fields);

      // papaayos mo ito sa chat gpt

        //redirect
        return redirect()->route('login')->with('success', 'Registration successful!');


    }

    public function login(Request $request)
{
    // Validate input
    $fields = $request->validate([
        'email' => ['required', 'email', 'max:50'],
        'password' => ['required']
    ]);

    // Attempt to log in with the provided credentials
    if (Auth::attempt($fields, $request->filled('remember'))) {
        // Authentication passed
        if (Auth::user()->role === 'admin') {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('profile');
        }
    } else {
        // Log the failed attempt
        Log::warning('Login attempt failed for: ' . $fields['email']);
        return back()->withErrors(['email' => 'Invalid credentials']);
    }
}


public function logout(Request $request)
{
    // Log the user out
    Auth::logout();

    // Invalidate the session
    $request->session()->invalidate();

    // Regenerate the CSRF token
    $request->session()->regenerateToken();

    // Set headers to prevent caching
    return redirect('/login')->withHeaders([
        'Cache-Control' => 'no-cache, no-store, must-revalidate, max-age=0',
        'Pragma' => 'no-cache',
        'Expires' => '0',
    ]);
}

public function storeBackupAccount(Request $request)
{
    // Validate the input
    $validatedData = $request->validate([
        'email' => 'required|email|unique:users,email',
        'password' => 'required|confirmed',
        'username' => 'required|string|max:255',
        'location' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
    ]);

    // Create the new admin account
    User::create([
        'email' => $validatedData['email'],
        'password' => Hash::make($validatedData['password']),
        'role' => 'admin',
        'username' => $validatedData['username'],
        'location' => $validatedData['location'],
        'phone' => $validatedData['phone'],
    ]);

    // Redirect back with success message
    return redirect()->back()->with('success', 'Backup account added successfully.');
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
