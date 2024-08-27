@extends('components.layoutAuth')

@section('auth')

<div class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md text-center">
        <h1 class="text-3xl font-bold text-green-600">Congratulations!</h1>
        <p class="mt-4 text-gray-600">Your account has been successfully created.</p>
        <a href="{{ route('login') }}" class="mt-6 inline-block px-6 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700">Login</a>
    </div>
    </div>

@endsection
