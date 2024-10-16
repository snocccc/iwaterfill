@extends('components.layoutAuth')

@section('auth')

<section class="min-h-screen bg-gradient-to-br from-[var(--color-dark-blue)] to-[var(--color-medium-blue)] flex flex-col md:flex-row">
    <!-- Left side - Company Branding -->
    <div class="md:w-1/2 hidden md:flex flex-col justify-center items-center text-white p-12">
        <div class="max-w-md text-center">
            <h1 class="text-4xl font-bold mb-4">iWaterFill</h1>
            <p class="text-xl mb-8">Empowering your digital journey</p>
            <div class="w-32 h-32 bg-white rounded-full mb-8 mx-auto flex items-center justify-center">
                <span class="text-[var(--color-dark-blue)] text-4xl font-bold">iWaterFill</span>
            </div>
            <p class="text-[var(--color-pale-blue)]">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>
    </div>

    <!-- Right side - Login Form -->
    <div class="md:w-1/2 flex items-center justify-center p-12">
        <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8 space-y-8">
            <div>
                <h2 class="mt-6 text-3xl font-extrabold text-[var(--color-dark-blue)]">Welcome Back</h2>
                <p class="mt-2 text-sm text-[var(--color-medium-blue)]">Sign in to your account</p>
            </div>
            <form class="mt-8 space-y-6" method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="sr-only">Email address</label>
                    <input id="email" name="email" type="email" autocomplete="email" required
                        class="appearance-none rounded-md relative block w-full px-3 py-2 border border-[var(--color-very-light-blue)] placeholder-[var(--color-very-light-blue)] text-[var(--color-dark-blue)] focus:outline-none focus:ring-[var(--color-light-blue)] focus:border-[var(--color-light-blue)] focus:z-10 sm:text-sm"
                        placeholder="Email address">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="sr-only">Password</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                        class="appearance-none rounded-md relative block w-full px-3 py-2 border border-[var(--color-very-light-blue)] placeholder-[var(--color-very-light-blue)] text-[var(--color-dark-blue)] focus:outline-none focus:ring-[var(--color-light-blue)] focus:border-[var(--color-light-blue)] focus:z-10 sm:text-sm"
                        placeholder="Password">
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox"
                            class="h-4 w-4 text-[var(--color-medium-blue)] focus:ring-[var(--color-light-blue)] border-[var(--color-very-light-blue)] rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-[var(--color-dark-blue)]">
                            Remember me
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <div class="text-sm">
                            <a href="{{ route('password.request') }}" class="font-medium text-[var(--color-medium-blue)] hover:text-[var(--color-light-blue)]">
                                Forgot your password?
                            </a>
                        </div>
                    @endif
                </div>

                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-[var(--color-medium-blue)] hover:bg-[var(--color-light-blue)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--color-light-blue)] transition duration-150 ease-in-out">
                        Sign in
                    </button>
                </div>
            </form>

            <!-- Sign Up Button -->
            <div class="mt-4 text-center">
                <p class="text-sm text-[var(--color-dark-blue)]">Don't have an account?</p>
                <a href="{{ route('register') }}" class="mt-2 w-full inline-flex justify-center py-2 px-4 border border-[var(--color-medium-blue)] text-sm font-medium rounded-md text-[var(--color-medium-blue)] bg-white hover:bg-[var(--color-pale-blue)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--color-light-blue)] transition duration-150 ease-in-out">
                    Sign up
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-[var(--color-dark-blue)] text-white py-4 mt-auto">
    <div class="max-w-6xl mx-auto text-center">
        <p class="text-sm">© 2024 iWaterFill. All rights reserved.</p>
        <div class="mt-2">
            <a href="#" class="text-[var(--color-pale-blue)] hover:underline">Privacy Policy</a>
            <span class="mx-2">|</span>
            <a href="#" class="text-[var(--color-pale-blue)] hover:underline">Terms of Service</a>
        </div>
    </div>
</footer>

@endsection
