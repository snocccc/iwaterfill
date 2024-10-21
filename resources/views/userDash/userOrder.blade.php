@extends('components.layoutUser')

@section('userDash')
<div class="min-h-screen bg-[#caf0f8] p-4">
    <div class="max-w-lg mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-[#03045e] to-[#0077b6] py-4 px-6">
            <h2 class="text-xl font-semibold text-white text-center">Make Order</h2>
        </div>

        <!-- Success Message -->
        @if (session('success'))
        <div class="m-4 p-3 bg-[#90e0ef] text-[#03045e] rounded-lg">
            {{ session('success') }}
        </div>
        @endif

        <!-- Products List -->
        <div class="p-4 space-y-3">
            @foreach ($products as $product)
            <div class="border border-[#90e0ef] rounded-lg hover:shadow-md transition-all duration-200"
                 x-data="{ open: false, quantity: 1,
                          total: {{ $product->price }},
                          updateTotal() { this.total = (this.quantity * {{ $product->price }}).toFixed(2) }
                        }">

                <!-- Product Header -->
                <div class="p-3 cursor-pointer" @click="open = !open">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="font-medium text-[#03045e]">{{ $product->product_Name }}</h3>
                            <p class="text-sm text-[#0077b6]">{{ $product->description }}</p>
                        </div>
                        <span class="font-semibold text-[#00b4d8]">${{ $product->price }}</span>
                    </div>
                </div>

                <!-- Order Form -->
                <div x-show="open"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     class="border-t border-[#90e0ef] p-3 bg-[#f8f9fa]">

                    <form action="{{ route('userBuy') }}" method="POST" class="space-y-3">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <!-- Customer Name -->
                        <div>
                            <label class="block text-sm text-[#03045e] mb-1">Customer Name</label>
                            <input type="text"
                                   name="username"
                                   value="{{ auth()->user()->username }}"
                                   class="w-full p-2 bg-[#f0f9ff] border border-[#90e0ef] rounded-lg"
                                   readonly>
                        </div>

                        <!-- Quantity -->
                        <div>
                            <label class="block text-sm text-[#03045e] mb-1">Quantity</label>
                            <input type="number"
                                   name="quantity"
                                   x-model="quantity"
                                   @input="updateTotal"
                                   min="1"
                                   class="w-full p-2 border border-[#90e0ef] rounded-lg focus:border-[#00b4d8] focus:outline-none">
                        </div>

                        <!-- Total Price -->
                        <div>
                            <label class="block text-sm text-[#03045e] mb-1">Total Price</label>
                            <input type="number"
                                   name="price"
                                   x-model="total"
                                   class="w-full p-2 bg-[#f0f9ff] border border-[#90e0ef] rounded-lg"
                                   readonly>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                                class="w-full bg-[#00b4d8] hover:bg-[#0077b6] text-white p-2 rounded-lg transition-colors duration-200">
                            Place Order
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script defer src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js"></script>
@endsection
