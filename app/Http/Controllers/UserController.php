<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'phone' => ['required'],
            'password' => ['required', 'confirmed']
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


        public function logout(Request $request) {
            // Log the user out
            Auth::logout();

            // Invalidate the session
            $request->session()->invalidate();

            // Regenerate the CSRF token
            $request->session()->regenerateToken();

            // Redirect to login page
            return redirect('/');
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
