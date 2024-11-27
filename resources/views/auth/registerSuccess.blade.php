@extends('components.layoutAuth')
@section('title', 'Registration Successfully')
@section('auth')
<div class="flex justify-center items-center min-h-screen bg-gradient-to-r from-[var(--color-dark-blue)] via-[var(--color-medium-blue)] to-[var(--color-light-blue)]">
    <!-- Success Modal -->
    <div id="successModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

            <!-- Modal panel -->
            <div class="relative inline-block p-8 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-3xl shadow-xl sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                <div class="text-center">
                    <!-- Success icon -->
                    <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 rounded-full bg-green-100">
                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>

                    <h3 class="mb-2 text-2xl font-bold text-gray-900" id="modal-title">
                        Account Registration Successful
                    </h3>
                    <p class="mb-4 text-gray-500">
                        Your Account has been Created successfully. You will be redirected to the login page in <span id="countdown" class="font-semibold text-blue-600">3</span> seconds.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let count = 3;
            const countdown = document.getElementById('countdown');

            const timer = setInterval(() => {
                count--;
                if (countdown) {
                    countdown.textContent = count;
                }

                if (count === 0) {
                    clearInterval(timer);
                    window.location.href = "{{ route('login') }}";
                }
            }, 1000);
        });
    </script>
</div>
@endsection
