@extends('components.layoutAuth')

@section('auth')

    <div class="w-[400px] h-[500px] bg-white rounded-xl mt-[50px] shadow-xl bg-gradient-to-r from-blue-200 to-blue-300">
        <form class="mt-3" action="{{ route('register') }}" method="post">
            @csrf
            <h1 class="flex justify-center text-xl border-b border-black">Create An Account</h1>
            <div class="mr-10 ml-10 mb-1 mt-3">
                <label for="username" class="block text-sm font-medium text-gray-700 flex">Username
                    <i class="ri-user-3-line ml-2 font-bold font-bold ml-2"></i>
                    @error('username')
                    <p class="text-red-700 text-[10px] ml-9"> {{ $message }}</p>
                    @enderror
                </label>
                <input type="text" name="username" value="{{ old('username') }}" class="input p-1 rounded-lg border w-full">
            </div>

            <div class="mr-10 ml-10 mb-3">
                <label for="email" class="block text-sm font-medium text-gray-700 flex">Email
                    <i class="ri-mail-line font-bold ml-2"></i>
                    @error('email')
                    <p class="text-red-700 text-[10px] ml-[70px]"> {{ $message }}</p>
                    @enderror
                </label>
                <input type="text" name="email" value="{{ old('email') }}" class="input p-1 rounded-lg border w-full">
            </div>

            <div class="mr-10 ml-10 mb-3">
                <label for="location" class="block text-sm font-medium text-gray-700 flex">Location
                    <i class="ri-map-pin-line font-bold ml-2"></i>
                    @error('location')
                    <p class="text-red-700 text-[10px] ml-9"> {{ $message }}</p>
                    @enderror
                </label>
                <input type="text" name="location" value="{{ old('location') }}" class="input p-1 rounded-lg border w-full">
            </div>

            <div class="mr-10 ml-10 mb-3">
                <label for="phone" class="block text-sm font-medium text-gray-700 flex">Phone Number
                    <i class="ri-smartphone-line font-bold ml-2"></i>
                    @error('phone')
                    <p class="text-red-700 text-[10px] ml-9"> {{ $message }}</p>
                    @enderror
                </label>
                <input type="tel" name="phone" value="{{ old('phone') }}" class="input p-1 rounded-lg border w-full">
            </div>

            <div class="mr-10 ml-10 mb-3">
                <label for="paswword" class="block text-sm font-medium text-gray-700 flex">Password
                    <i class="ri-lock-2-line font-bold ml-2"></i>
                    @error('password')
                    <p class="text-red-700 text-[10px] ml-[50px]"> {{ $message }}</p>
                    @enderror
                </label>
                <input type="password" name="password" class="input p-1 rounded-lg border w-full">
            </div>

            <div class="mr-10 ml-10 mb-3">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 flex">Confirm Password
                    <i class="ri-lock-2-line font-bold ml-2"></i>
                    @error('password_confirmation')
                    <p class="text-red-700 text-[10px] ml-9"> {{ $message }}</p>
                    @enderror
                </label>
                <input type="password" name="password_confirmation"  class="input p-1 rounded-lg border w-full">
            </div>

            <div class="flex justify-center m-7">
                    <button class="mr-[100px] bg-white rounded-lg px-4">
                        <a href="{{ Route('login') }}">Cancel</a>
                    </button>
                    <button class="bg-[#002D74] text-white rounded-lg px-4">Register</button>
            </div>
        </form>
    </div>

    @endsection

