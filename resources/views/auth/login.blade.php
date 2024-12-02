@extends('components.layoutAuth')
@section('title', 'Login')
@section('auth')
<style>
    @media (max-width: 768px) {
    #privacy-policy-modal .modal-content,
    #terms-of-service-modal .modal-content {
        max-width: 90%; /* Adjust width for smaller screens */
        height: auto;
        overflow-y: auto; /* Enable scrolling if content overflows */
        padding: 1rem; /* Add padding */
    }
}

</style>

    <section class="min-h-screen bg-gradient-to-br from-[var(--color-dark-blue)] to-[var(--color-medium-blue)] flex flex-col md:flex-row">
        <!-- Left side - Company Branding -->
<div class="md:w-1/2 hidden md:flex flex-col justify-center items-center text-white p-12">
    <div class="max-w-md">
        <h1 class="text-5xl font-extrabold mb-6 tracking-tight drop-shadow-lg ml-[30px]">Lola A's Tubigan</h1>
        <div class="w-72 h-72 mx-auto mb-8 rounded-full border-8 border-white shadow-2xl overflow-hidden">
            <img src="{{ asset('images/logo.png') }}" alt="iWaterFill Logo" class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-300">
            </div>
            <p class="text-2xl font-light opacity-90 ml-[40px]">Empowering your hydration experience</p>
            </div>
            </div>

    <!-- Right side - Login Form -->
    <div class="md:w-1/2 flex items-center justify-center p-12">
        <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8 space-y-8">
            <div>
                <h2 class="mt-6 text-3xl font-extrabold text-[var(--color-dark-blue)]">Welcome Back</h2>
                <p class="mt-2 text-sm text-[var(--color-medium-blue)]">Sign in to your account</p>
                </div>

                <!-- Error Message -->
                @if ($errors->any())
                <div class="bg-red-500 text-white p-4 rounded-lg mb-6">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

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

                            <div class="text-sm">
                                <a href="{{ route('password.request') }}" class="font-medium text-[var(--color-medium-blue)] hover:text-[var(--color-light-blue)]">
                                    Forgot Password?
                                </a>
                            </div>
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
                    <footer class="fixed bottom-0 left-0 right-0 bg-[var(--color-dark-blue)] text-white py-4">
                        <div class="max-w-6xl mx-auto text-center">
                            <p class="text-sm">© 2024 iWaterFill. All rights reserved.</p>
                            <div class="mt-2">
                                <a href="#" class="text-[var(--color-pale-blue)] hover:underline">Privacy Policy</a>
                                <span class="mx-2">|</span>
                                <a href="#" class="text-[var(--color-pale-blue)] hover:underline">Terms of Service</a>
                                </div>
                                </div>
                                </footer>

                             <!-- Terms of Service Modal -->
<div id="terms-of-service-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="modal-content bg-white rounded-lg shadow-lg max-w-2xl w-full p-6 overflow-y-auto max-h-[90vh]">
        <h2 class="text-2xl font-bold text-[var(--color-dark-blue)] mb-4">Terms of Service</h2>
        <p class="text-sm text-gray-600 mb-4">
            Welcome to Lola A's Tubigan! By using our services, you agree to the following terms and conditions:
        </p>
        <p class="text-sm text-gray-600 mb-4">
            Information We Collect: We may collect information such as your name, email, contact details, and transaction history to enhance our services.
        </p>
        <p class="text-sm text-gray-600 mb-4">
            How We Use Your Information: Your data is used for order processing, account management, and improving our services. We do not share your personal information with third parties without your consent.
        </p>
        <p class="text-sm text-gray-600 mb-4">
            Security: We employ the latest security measures to protect your data from unauthorized access.
        </p>
        <p class="text-sm text-gray-600">
            By using our services, you agree to this Privacy Policy. We reserve the right to update this policy as needed.
        </p>
        <div class="mt-6 flex justify-end space-x-2">
            <button onclick="toggleModal('terms-of-service-modal')" class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300">Close</button>
        </div>
    </div>
</div>

<!-- Privacy Policy Modal -->
<div id="privacy-policy-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="modal-content bg-white rounded-lg shadow-lg max-w-2xl w-full p-6 overflow-y-auto max-h-[90vh]">
        <h2 class="text-2xl font-bold text-[var(--color-dark-blue)] mb-4">Privacy Policy</h2>
        <p class="text-sm text-gray-600 mb-4">
            Lola A's Tubigan is committed to protecting your privacy. This policy explains how we collect, use, and safeguard your personal information.
        </p>
        <p class="text-sm text-gray-600 mb-4">
            1. Use of Service: Our platform is provided for personal, non-commercial use. You must not misuse the services or violate applicable laws.
        </p>
        <p class="text-sm text-gray-600 mb-4">
            2. Account Responsibilities: You are responsible for maintaining the confidentiality of your account credentials and for all activities under your account.
        </p>
        <p class="text-sm text-gray-600 mb-4">
            3. Orders and Payments: All orders are subject to availability. Prices are displayed at the time of checkout and must be paid in full.
        </p>
        <p class="text-sm text-gray-600 mb-4">
            4. Limitations of Liability: Lola A's Tubigan is not liable for any indirect or consequential losses resulting from the use of our services.
        </p>
        <p class="text-sm text-gray-600">
            By continuing to use our services, you agree to these terms. We reserve the right to modify these terms at any time.
        </p>
        <div class="mt-6 flex justify-end space-x-2">
            <button onclick="toggleModal('privacy-policy-modal')" class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300">Close</button>
        </div>
    </div>
</div>

<!-- Footer Update -->
<footer class="fixed bottom-0 left-0 right-0 bg-[var(--color-dark-blue)] text-white py-4">
    <div class="max-w-6xl mx-auto text-center">
        <p class="text-sm">© 2024 Lola A's Tubigan. All rights reserved.</p>
        <div class="mt-2">
            <a href="javascript:void(0)" onclick="toggleModal('privacy-policy-modal')" class="text-[var(--color-pale-blue)] hover:underline">Privacy Policy</a>
            <span class="mx-2">|</span>
            <a href="javascript:void(0)" onclick="toggleModal('terms-of-service-modal')" class="text-[var(--color-pale-blue)] hover:underline">Terms of Service</a>
        </div>
    </div>
</footer>

<!-- Modal Toggle Script -->
<script>
    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.toggle('hidden');
    }
</script>
<!-- Privacy Policy Modal -->
<div id="privacy-policy-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full p-6 overflow-y-auto max-h-[90vh]">
        <h2 class="text-2xl font-bold text-[var(--color-dark-blue)] mb-4">Privacy Policy</h2>
        <p class="text-sm text-gray-600 mb-4">
            Lola A's Tubigan is committed to protecting your privacy. This policy explains how we collect, use, and safeguard your personal information.
        </p>
        <p class="text-sm text-gray-600 mb-4">
            Information We Collect: We may collect information such as your name, email, contact details, and transaction history to enhance our services.
        </p>
        <p class="text-sm text-gray-600 mb-4">
            How We Use Your Information: Your data is used for order processing, account management, and improving our services. We do not share your personal information with third parties without your consent.
        </p>
        <p class="text-sm text-gray-600 mb-4">
            Security: We employ the latest security measures to protect your data from unauthorized access.
        </p>
        <p class="text-sm text-gray-600">
            By using our services, you agree to this Privacy Policy. We reserve the right to update this policy as needed.
        </p>
        <div class="mt-6 flex justify-end space-x-2">
            <button onclick="toggleModal('privacy-policy-modal')" class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300">Close</button>
        </div>
    </div>
</div>

<!-- Terms of Service Modal -->
<div id="terms-of-service-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full p-6 overflow-y-auto max-h-[90vh]">
        <h2 class="text-2xl font-bold text-[var(--color-dark-blue)] mb-4">Terms of Service</h2>
        <p class="text-sm text-gray-600 mb-4">
            Welcome to Lola A's Tubigan! By using our services, you agree to the following terms and conditions:
        </p>
        <p class="text-sm text-gray-600 mb-4">
            1. Use of Service: Our platform is provided for personal, non-commercial use. You must not misuse the services or violate applicable laws.
        </p>
        <p class="text-sm text-gray-600 mb-4">
            2. Account Responsibilities: You are responsible for maintaining the confidentiality of your account credentials and for all activities under your account.
        </p>
        <p class="text-sm text-gray-600 mb-4">
            3. Orders and Payments: All orders are subject to availability. Prices are displayed at the time of checkout and must be paid in full.
        </p>
        <p class="text-sm text-gray-600 mb-4">
            4. Limitations of Liability: Lola A's Tubigan is not liable for any indirect or consequential losses resulting from the use of our services.
        </p>
        <p class="text-sm text-gray-600">
            By continuing to use our services, you agree to these terms. We reserve the right to modify these terms at any time.
        </p>
        <div class="mt-6 flex justify-end space-x-2">
            <button onclick="toggleModal('terms-of-service-modal')" class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300">Close</button>
        </div>
    </div>
</div>

<!-- Footer Update -->
<footer class="fixed bottom-0 left-0 right-0 bg-[var(--color-dark-blue)] text-white py-4">
    <div class="max-w-6xl mx-auto text-center">
        <p class="text-sm">© 2024 Lola A's Tubigan. All rights reserved.</p>
        <div class="mt-2">
            <a href="javascript:void(0)" onclick="toggleModal('privacy-policy-modal')" class="text-[var(--color-pale-blue)] hover:underline">Privacy Policy</a>
            <span class="mx-2">|</span>
            <a href="javascript:void(0)" onclick="toggleModal('terms-of-service-modal')" class="text-[var(--color-pale-blue)] hover:underline">Terms of Service</a>
        </div>
    </div>
</footer>

<!-- Modal Toggle Script -->
<script>
    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.toggle('hidden');
    }
</script>


@endsection
