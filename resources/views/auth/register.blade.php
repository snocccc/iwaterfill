@extends('components.layoutAuth')

@section('auth')

<div class="flex justify-center items-center min-h-screen bg-gradient-to-r from-[var(--color-dark-blue)] via-[var(--color-medium-blue)] to-[var(--color-light-blue)]">
    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-8 space-y-8">
        <h1 class="text-3xl font-extrabold text-center text-[var(--color-dark-blue)]">Create An Account</h1>

        <form id="registration-form" action="{{ route('register') }}" method="post" class="space-y-6">
            @csrf

            <div id="phase-1" class="space-y-4">
              <!-- Username -->
<div>
    <label for="username" class="block text-sm font-medium text-[var(--color-dark-blue)]">Username</label>
    <div class="mt-1 relative rounded-md shadow-sm">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <i class="ri-user-3-line text-[var(--color-medium-blue)]"></i>
        </div>
        <input type="text" name="username" id="username" value="{{ old('username') }}"
            class="block w-full pl-10 pr-3 py-2 border border-[var(--color-very-light-blue)] rounded-md leading-5
            bg-white placeholder-[var(--color-medium-blue)] focus:outline-none focus:ring-2 focus:ring-[var(--color-light-blue)]
            focus:border-[var(--color-light-blue)] sm:text-sm"
            placeholder="Enter your username" required>
    </div>
    @error('username')
    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>


                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-[var(--color-dark-blue)]">Email</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-mail-line text-[var(--color-medium-blue)]"></i>
                        </div>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="block w-full pl-10 pr-3 py-2 border border-[var(--color-very-light-blue)] rounded-md leading-5 bg-white placeholder-[var(--color-medium-blue)] focus:outline-none focus:ring-2 focus:ring-[var(--color-light-blue)] focus:border-[var(--color-light-blue)] sm:text-sm" placeholder="Enter your email" required>
                    </div>
                    @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div id="phase-2" class="space-y-4 hidden">
                <!-- Location -->
                <div>
                    <label for="location" class="block text-sm font-medium text-[var(--color-dark-blue)]">Location</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-map-pin-line text-[var(--color-medium-blue)]"></i>
                        </div>
                        <input type="text" name="location" id="location" value="{{ old('location') }}" class="block w-full pl-10 pr-3 py-2 border border-[var(--color-very-light-blue)] rounded-md leading-5 bg-white placeholder-[var(--color-medium-blue)] focus:outline-none focus:ring-2 focus:ring-[var(--color-light-blue)] focus:border-[var(--color-light-blue)] sm:text-sm" placeholder="Enter your location" required>
                    </div>
                    @error('location')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone Number -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-[var(--color-dark-blue)]">Phone Number</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-smartphone-line text-[var(--color-medium-blue)]"></i>
                        </div>
                        <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" class="block w-full pl-10 pr-3 py-2 border border-[var(--color-very-light-blue)] rounded-md leading-5 bg-white placeholder-[var(--color-medium-blue)] focus:outline-none focus:ring-2 focus:ring-[var(--color-light-blue)] focus:border-[var(--color-light-blue)] sm:text-sm" placeholder="Enter your phone number" required>
                    </div>
                    @error('phone')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div id="phase-3" class="space-y-4 hidden">
                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-[var(--color-dark-blue)]">Password</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-lock-2-line text-[var(--color-medium-blue)]"></i>
                        </div>
                        <input type="password" name="password" id="password" class="block w-full pl-10 pr-3 py-2 border border-[var(--color-very-light-blue)] rounded-md leading-5 bg-white placeholder-[var(--color-medium-blue)] focus:outline-none focus:ring-2 focus:ring-[var(--color-light-blue)] focus:border-[var(--color-light-blue)] sm:text-sm" placeholder="Create a password" required>
                    </div>
                    @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-[var(--color-dark-blue)]">Confirm Password</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-lock-2-line text-[var(--color-medium-blue)]"></i>
                        </div>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="block w-full pl-10 pr-3 py-2 border border-[var(--color-very-light-blue)] rounded-md leading-5 bg-white placeholder-[var(--color-medium-blue)] focus:outline-none focus:ring-2 focus:ring-[var(--color-light-blue)] focus:border-[var(--color-light-blue)] sm:text-sm" placeholder="Confirm your password">
                    </div>
                    @error('password_confirmation')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex justify-between pt-4">
                <button type="button" id="prev-btn" class="hidden inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-[var(--color-dark-blue)] bg-[var(--color-pale-blue)] hover:bg-[var(--color-very-light-blue)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--color-light-blue)]">
                    Previous
                </button>
                <button type="button" id="next-btn" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-[var(--color-medium-blue)] hover:bg-[var(--color-dark-blue)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--color-light-blue)]">
                    Next
                </button>
                <button type="submit" id="submit-btn" class="hidden inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-[var(--color-medium-blue)] hover:bg-[var(--color-dark-blue)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--color-light-blue)]">
                    Register
                </button>
            </div>
        </form>
    </div>
</div>

<script>
   document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registration-form');
    const phase1 = document.getElementById('phase-1');
    const phase2 = document.getElementById('phase-2');
    const phase3 = document.getElementById('phase-3');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const submitBtn = document.getElementById('submit-btn');

    let currentPhase = 1;

    function showPhase(phase) {
        phase1.classList.add('hidden');
        phase2.classList.add('hidden');
        phase3.classList.add('hidden');

        if (phase === 1) {
            phase1.classList.remove('hidden');
            prevBtn.classList.add('hidden');
            nextBtn.classList.remove('hidden');
            submitBtn.classList.add('hidden');
        } else if (phase === 2) {
            phase2.classList.remove('hidden');
            prevBtn.classList.remove('hidden');
            nextBtn.classList.remove('hidden');
            submitBtn.classList.add('hidden');
        } else if (phase === 3) {
            phase3.classList.remove('hidden');
            prevBtn.classList.remove('hidden');
            nextBtn.classList.add('hidden');
            submitBtn.classList.remove('hidden');
        }
    }

    function validatePhase() {
        const inputs = document.querySelectorAll(`#phase-${currentPhase} input[required]`);
        let isValid = true;

        inputs.forEach(input => {
            if (!input.value) {
                input.setCustomValidity('Please fill out this field.');
                input.reportValidity();
                isValid = false;
            } else {
                input.setCustomValidity('');
            }
        });

        return isValid;
    }

    nextBtn.addEventListener('click', function() {
        if (validatePhase() && currentPhase < 3) {
            currentPhase++;
            showPhase(currentPhase);
        }
    });

    prevBtn.addEventListener('click', function() {
        if (currentPhase > 1) {
            currentPhase--;
            showPhase(currentPhase);
        }
    });

    showPhase(1);
});

</script>
@endsection
