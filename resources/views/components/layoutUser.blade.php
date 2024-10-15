<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title>User</title>
    <style>
        :root {
            --color-dark-blue: #03045E;
            --color-medium-blue: #0077B6;
            --color-light-blue: #00B4D8;
            --color-very-light-blue: #90E0EF;
            --color-pale-blue: #CAF0F8;
        }
        body {
            background-color: var(--color-pale-blue);
        }
        .sidebar {
            background-color: var(--color-dark-blue);
        }
        .sidebar a {
            transition: background-color 0.3s ease;
        }
        .sidebar a:hover {
            background-color: var(--color-medium-blue);
        }
        .sidebar a.active {
            background-color: var(--color-light-blue);
            color: var(--color-dark-blue);
        }
        .main-content {
            background: linear-gradient(to right, var(--color-very-light-blue), var(--color-pale-blue));
        }
        .header {
            background-color: var(--color-light-blue);
        }
        .btn-primary {
            background-color: var(--color-medium-blue);
            color: white;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: var(--color-dark-blue);
        }
    </style>
</head>
<body class="font-mont">

    <div class="flex flex-col lg:flex-row lg:min-h-screen">

        <!-- Sidebar -->
        <div class="fixed inset-0 z-40 bg-opacity-75 lg:hidden sidebar"></div>
        <div class="fixed inset-y-0 left-0 w-64 lg:relative lg:w-64 lg:flex lg:flex-col lg:shadow-md lg:overflow-y-auto z-50 sidebar">
            <div class="flex items-center justify-between p-4 lg:hidden">
                <button class="text-white text-2xl">
                    <i class="ri-menu-line"></i>
                </button>
            </div>
            <div class="flex flex-col p-4 h-full lg:h-auto">
                <a href="#" class="flex items-center pb-4 border-b border-gray-200 mb-4">
                    <img class="w-12 h-12 rounded object-cover" src="a.jpg" alt="">
                    <h1 class="text-white font-bold text-xl ml-2">iWaterFill</h1>
                </a>
                <nav class="space-y-2 overflow-y-auto lg:overflow-y-auto">
                    <a href="{{ route('profile') }}" class="flex items-center p-3 text-gray-200 text-base rounded-lg {{ request()->routeIs('profile') ? 'active' : '' }}">
                        <i class="ri-home-8-line mr-3"></i>
                        <span>Profile</span>
                    </a>
                    <a href="{{ route('userOrder') }}" class="flex items-center p-3 text-gray-200 text-base rounded-lg {{ request()->routeIs('purchase') ? 'active' : '' }}">
                        <i class="ri-shopping-bag-line mr-3"></i>
                        <span>Add Order</span>
                    </a>

                    <a href="{{ route('userHistory') }}" class="flex items-center p-3 text-gray-200 text-base rounded-lg {{ request()->routeIs('history') ? 'active' : '' }}">
                        <i class="ri-history-line mr-3"></i>
                        <span>Order History</span>
                    </a>

                    <a href="" class="flex items-center p-3 text-gray-200 text-base rounded-lg {{ request()->routeIs('history') ? 'active' : '' }}">
                        <i class="ri-shopping-cart-line mr-3"></i>
                        <span>Order</span>
                    </a>


                </nav>
                <!-- Logout Button -->
                <div class="mt-auto pt-4 border-t border-gray-200">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center w-full p-3 text-gray-200 text-base rounded-lg hover:bg-red-600 transition-colors duration-300">
                            <i class="ri-logout-box-line mr-3"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex-1 min-h-screen lg:ml-0 lg:pl-0 lg:py-0 main-content">
            <div class="flex items-center justify-between p-4 lg:hidden header">
                <button class="text-3xl text-gray-700">
                    <i class="ri-menu-line"></i>
                </button>
                <div class="relative grid place-items-center">
                    <button type="button" class="rounded-full overflow-hidden">
                        <img src="https://picsum.photos/id/35/35" alt="">
                    </button>
                    <div class="bg-white shadow-lg absolute rounded-lg overflow-hidden mt-12 right-0">
                        <p class="font-light pl-4 w-full">{{ auth()->user()->email }}</p>
                        <hr class="border-gray-300">
                        <a href="{{ route('dashboard') }}" class="block hover:bg-slate-100 pr-4 mb-1 pl-4">Dashboard</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="block hover:bg-slate-100 pr-4 mb-1 pl-4 w-full">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
            @yield('userDash')
        </main>
    </div>

</body>
</html>
