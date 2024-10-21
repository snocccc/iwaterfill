<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
     // Kunin ang naka-authenticate na user
     $user = Auth::user();

    return view('userDash.userProfile', compact('user'));
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
    public function edit()
{
    $user = Auth::user();  // Kunin ang authenticated user
    return view('userDash.userEdit', compact('user'));
}

public function update(Request $request)
{
    $user = Auth::user();  // Kunin ang authenticated user

    // Validation ng mga input
    $validated = $request->validate([
        'username' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'location' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:15',
    ]);

    // I-update ang user data
    $user->update($validated);

    return redirect()->route('profile')
        ->with('success', 'Profile updated successfully.');
}

public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|confirmed',
    ]);

    $user = Auth::user();

    // I-verify kung tama ang kasalukuyang password
    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Mali ang kasalukuyang password.']);
    }

    // I-update ang password
    $user->password = Hash::make($request->new_password);
    $user->save();

    return back()->with('success', 'Password updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
