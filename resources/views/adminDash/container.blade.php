@extends('components.layoutDash')
@section('title', 'Admin Inventory')
@section('dash')
<section class="min-h-screen bg-gradient-to-br from-blue-50 to-cyan-50 p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-blue-900 mb-2">
                Welcome back, {{ auth()->user()->username }}
            </h1>
            <p class="text-blue-600/75">Manage your inventory with ease</p>
        </div>

        @if(session('success'))
            <div class="mb-6 transform transition-all animate-fadeIn">
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r">
                    <div class="flex">
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Products Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @foreach($allProducts as $product)
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $product->product_Name }}</h3>
                        <button
                            onclick="toggleStockInput({{ $product->id }})"
                            class="text-blue-500 hover:text-blue-700 transition-colors"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </button>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="text-3xl font-bold text-blue-900">{{ $product->stock }}</div>
                        <div class="text-sm text-gray-500">units in stock</div>
                    </div>

                    <!-- Edit Stock Form -->
                    <div id="stockInputForm{{ $product->id }}" class="hidden mt-4">
                        <form action="{{ route('updateProducts') }}" method="POST">
                            @csrf
                            <div class="space-y-3">
                                <div>
                                    <label class="text-sm font-medium text-gray-700">Update Stock</label>
                                    <input
                                        type="number"
                                        name="stock[{{ $product->id }}]"
                                        value="{{ $product->stock }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    >
                                </div>
                                <button
                                    type="submit"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors"
                                >
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeIn {
        animation: fadeIn 0.3s ease-out;
    }
</style>

<script>
    function toggleStockInput(id) {
        const form = document.getElementById(`stockInputForm${id}`);
        if (form.classList.contains('hidden')) {
            form.classList.remove('hidden');
            form.classList.add('animate-fadeIn');
        } else {
            form.classList.add('hidden');
        }
    }
</script>
@endsection
