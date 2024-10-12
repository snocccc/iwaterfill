@extends('components.layoutAuth')

@section('auth')

<section>
    <div class="w-full max-w-[900px] h-[475px] bg-[#9EB7E5] bg-gradient-to-r from-[#9EB7E5] to-[#8DACE7] border rounded-[15px] flex flex-col md:flex-row items-center shadow-lg">
        <div class="w-full md:w-1/2 m-[20px] md:m-[50px] lg:m-[100px] hidden sm:block rounded-2xl">
            <img class="h-[200px] w-[240px] pl-[30px] md:pl-[60px] lg:pl-[90px]" src="a.jpg" alt="">
            <h1 class="text-3xl md:text-4xl m-3">iWaterFill:</h1>
            <h2 class="text-xl md:text-2xl">Water Refilling Station</h2>
        </div>

        <div class="bg-[#c9d6ff] w-full md:w-1/2 m-4 h-auto md:h-[400px] border rounded-[14px] shadow-lg">
            <h1 class="text-xl md:text-2xl font-bold ml-4 mt-2 text-[#002D74]">Login</h1>
            <p class="text-sm ml-4 mt-1">If You Already A Member, Please Login</p>
            <form action="{{ route('login') }}" method="POST" class="flex flex-col gap-4 px-4 py-2">
                @csrf
                <input value="{{ old('email') }}" class="p-2 rounded-lg border" type="email" name="email" placeholder="Email">
                <div class="relative">
                    <input class="p-2 rounded-lg border w-full" type="password" name="password" placeholder="Password">
                    <i class="bi bi-eye absolute bottom-2 right-2 fill-red-400"></i>
                </div>

                <div>
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Remember me</label>
                </div>

                @error('failed')
                    <p class="error text-red-700 text-[10px]"> {{ $message }}</p>
                @enderror

                <button class="bg-[#002D74] text-white rounded-xl py-2">
                    <a href="{{ route('dashboard') }}">Login</a>
                </button>
            </form>

            <div class="grid grid-cols-3 items-center my-4">
                <hr class="border-gray-400">
                <p class="text-center text-gray-500">OR</p>
                <hr class="border-gray-400">
            </div>

            <button class="bg-white border py-2 w-full rounded-xl flex justify-center items-center text-sm">
                <!-- SVG icon for Google Login -->
                <svg class="mr-3" xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 48 48">
                    <!-- Path elements -->
                </svg>
                Login With Google
            </button>

            <p class="text-sm text-center text-gray-700 my-4">
                <a href="#">Forgot Your Password?</a>
            </p>

            <div class="text-sm text-center text-gray-700">
                <p>If You Don't Have An Account.</p>
            </div>

            <div class="flex justify-center">
                <button class="px-5 py-2 bg-white border rounded-lg text-sm mt-2">
                    <a href="{{ route('register') }}">Sign Up</a>
                </button>
            </div>
        </div>
    </div>
</section>

@endsection
