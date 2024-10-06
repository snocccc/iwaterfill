@extends('components.layoutDash')

@section('dash')
<section class="p-4 min-h-screen" style="background-color: #caf0f8;">
    <div class="text-xl font-medium text-center mb-4" style="color: #03045e;">
        <h1>Hello, {{ auth()->user()->username }}</h1>
    </div>

    @if(session('success'))
        <div class="px-3 py-2 rounded mb-4" style="background-color: #90e0ef; border: 1px solid #00b4d8; color: #03045e;">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="container mx-auto space-y-4">
        <!-- Section for Total Quantity of Each Product -->
        <div class="p-4 rounded shadow-sm mb-4" style="background-color: #f0f8ff;">
            <h3 class="font-medium text-base mb-2 flex justify-between items-center" style="color: #0077b6;">
                Total Quantity of Each Product
                <button onclick="toggleForm('editForm')" class="text-sm focus:outline-none" style="color: #00b4d8;">
                    Edit
                </button>
            </h3>
            <ul class="list-none pl-0 space-y-1">
                @foreach($allProducts as $product)
                    <li class="text-gray-700">{{ $product->product_Name }}:
                        <span class="font-medium" style="color: #03045e;">{{ $product->stock }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Edit Form for Total Quantity -->
        <div id="editForm" style="display: none;" class="p-4 rounded shadow-sm mb-4" style="background-color: #f0f8ff;">
            <h3 class="font-medium text-base mb-2" style="color: #0077b6;">Edit Product Quantities</h3>
            <form action="{{ route('updateProducts') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 gap-2">
                    @foreach($allProducts as $product)
                        <div>
                            <label class="block text-sm" style="color: #03045e;">{{ $product->product_Name }}:</label>
                            <input type="number" name="stock[{{ $product->id }}]" value="{{ $product->stock }}" class="mt-1 block w-full border rounded p-1 text-sm" style="border-color: #90e0ef;">
                        </div>
                    @endforeach
                </div>
                <div class="mt-3">
                    <button type="submit" class="px-3 py-1 rounded text-sm" style="background-color: #0077b6; color: white;">Save Changes</button>
                </div>
            </form>
        </div>

        <!-- Section for Total Containers -->
        <div class="p-4 rounded shadow-sm mb-4" style="background-color: #f0f8ff;">
            <h3 class="text-base font-medium mb-2" style="color: #0077b6;">Available Containers</h3>
            <ul class="list-none pl-0 space-y-1">
                @foreach($containers as $container)
                    <li class="text-gray-700">{{ $container->product_Name }}:
                        <span class="font-medium" style="color: #03045e;">{{ $container->availableCon }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Borrow and Return Buttons -->
        <div class="flex space-x-2">
            <button onclick="toggleForm('borrowForm'); hideForm('returnForm')" class="px-3 py-1 rounded text-sm transition" style="background-color: #00b4d8; color: white;">
                Borrow Container
            </button>
            <button onclick="toggleForm('returnForm'); hideForm('borrowForm')" class="px-3 py-1 rounded text-sm transition" style="background-color: #0077b6; color: white;">
                Return Container
            </button>
        </div>

        <!-- Borrow Form -->
        <form action="{{ route('borrowContainer') }}" method="POST" id="borrowForm" style="display: none;" class="p-4 rounded shadow-sm mt-4" style="background-color: #f0f8ff;">
            @csrf
            <h3 class="font-medium text-base mb-2" style="color: #0077b6;">Borrow Container</h3>
            <div class="mb-2">
                <label for="product_name" class="block text-sm" style="color: #03045e;">Select Container:</label>
                <select name="product_name" class="mt-1 block w-full border rounded p-1 text-sm" style="border-color: #90e0ef;">
                    @foreach($containers as $container)
                        <option value="{{ $container->product_Name }}">{{ $container->product_Name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-2">
                <label for="borrow_quantity" class="block text-sm" style="color: #03045e;">Quantity:</label>
                <input type="number" name="borrow_quantity" min="1" required class="mt-1 block w-full border rounded p-1 text-sm" style="border-color: #90e0ef;">
            </div>

            <button type="submit" class="px-3 py-1 rounded text-sm transition" style="background-color: #00b4d8; color: white;">Confirm Borrow</button>
        </form>

        <!-- Return Form -->
        <form action="{{ route('returnContainer') }}" method="POST" id="returnForm" style="display: none;" class="p-4 rounded shadow-sm mt-4" style="background-color: #f0f8ff;">
            @csrf
            <h3 class="font-medium text-base mb-2" style="color: #0077b6;">Return Container</h3>
            <div class="mb-2">
                <label for="return_product_name" class="block text-sm" style="color: #03045e;">Select Container:</label>
                <select name="return_product_name" class="mt-1 block w-full border rounded p-1 text-sm" style="border-color: #90e0ef;">
                    @foreach($containers as $container)
                        <option value="{{ $container->product_Name }}">{{ $container->product_Name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-2">
                <label for="return_quantity" class="block text-sm" style="color: #03045e;">Quantity:</label>
                <input type="number" name="return_quantity" min="1" required class="mt-1 block w-full border rounded p-1 text-sm" style="border-color: #90e0ef;">
            </div>

            <button type="submit" class="px-3 py-1 rounded text-sm transition" style="background-color: #00b4d8; color: white;">Confirm Return</button>
        </form>
    </div>
</section>

<script>
    function toggleForm(formId) {
        var form = document.getElementById(formId);
        if (form.style.display === "none") {
            form.style.display = "block";
        } else {
            form.style.display = "none";
        }
    }

    function hideForm(formId) {
        var form = document.getElementById(formId);
        form.style.display = "none";
    }
</script>
@endsection
