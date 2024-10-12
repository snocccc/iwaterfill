<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        if (Auth::attempt($fields, $request->filled('remember'))) {
            // Authentication passed

            if (Auth::user()->role === 'admin') {
                return redirect()->route('dashboard'); // Gamit ang return para sa tamang pag-redirect
            } else {
                return redirect()->route('userPayment'); // Gamit ang return para sa tamang pag-redirect
            }



        } // papaayos mo ito sa chat gpt

        //redirect
        return redirect()->route('login');

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
            return redirect()->route('dashboard'); // Gamit ang return para sa tamang pag-redirect
        } else {
            return redirect()->route('userPayment'); // Gamit ang return para sa tamang pag-redirect
        }



    }

    // Authentication failed, redirect back with an error
    return back()->withErrors([
        'failed' => 'The provided credentials do not match our records.',
    ]);
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
