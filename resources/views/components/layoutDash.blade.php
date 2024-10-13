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

    <title>Purchase History</title>
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
            font-family: 'Montserrat', sans-serif;
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
    <div class="flex flex-col lg:flex-row min-h-screen">
        <!-- Sidebar for mobile -->
        <div id="mobileSidebar" class="fixed inset-0 z-50 bg-gray-800 bg-opacity-75 hidden">
            <div class="fixed inset-y-0 left-0 w-64 bg-dark-blue overflow-y-auto">
                <div class="flex items-center justify-between p-4">
                    <a href="#" class="flex items-center">
                        <img class="w-10 h-10 rounded object-cover" src="a.jpg" alt="">
                        <h1 class="text-white font-bold text-xl ml-2">iWaterFill</h1>
                    </a>
                    <button id="closeMobileSidebar" class="text-white text-2xl">
                        <i class="ri-close-line"></i>
                    </button>
                </div>
                <!-- Mobile Navigation Menu -->
                <nav class="mt-5 px-2">
                    <!-- Add your mobile navigation items here if needed -->
                </nav>
            </div>
        </div>

        <!-- Desktop Sidebar -->
        <div class="hidden lg:flex lg:flex-col lg:w-64 lg:fixed lg:inset-y-0 z-50 sidebar">
            <div class="flex items-center justify-center h-16 px-4">
                <img class="w-10 h-10 rounded object-cover" src="a.jpg" alt="">
                <h1 class="text-white font-bold text-xl ml-2">iWaterFill</h1>
            </div>
            <div class="flex-1 flex flex-col overflow-y-auto">
                <nav class="flex-1 px-2 py-4 space-y-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center p-3 text-gray-200 text-base rounded-lg {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="ri-home-8-line mr-3"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('purchase') }}" class="flex items-center p-3 text-gray-200 text-base rounded-lg {{ request()->routeIs('purchase') ? 'active' : '' }}">
                        <i class="ri-shopping-bag-line mr-3"></i>
                        <span>Add Purchase</span>
                    </a>
                    <a href="{{ route('customerList') }}" class="flex items-center p-3 text-gray-200 text-base rounded-lg {{ request()->routeIs('customerList') ? 'active' : '' }}">
                        <i class="ri-user-line mr-3"></i>
                        <span>Customer List</span>
                    </a>
                    <a href="{{ route('addProduct') }}" class="flex items-center p-3 text-gray-200 text-base rounded-lg {{ request()->routeIs('addProduct') ? 'active' : '' }}">
                        <i class="ri-add-circle-line mr-3"></i>
                        <span>Add Product</span>
                    </a>
                    <a href="{{ route('history') }}" class="flex items-center p-3 text-gray-200 text-base rounded-lg {{ request()->routeIs('history') ? 'active' : '' }}">
                        <i class="ri-history-line mr-3"></i>
                        <span>Purchase History</span>
                    </a>
                    <a href="{{ route('container') }}" class="flex items-center p-3 text-gray-200 text-base rounded-lg {{ request()->routeIs('availableContainer') ? 'active' : '' }}">
                        <i class="ri-database-2-line mr-3"></i>
                        <span>Available Container</span>
                    </a>
                    <a href="#" class="flex items-center p-3 text-gray-200 text-base rounded-lg {{ request()->routeIs('report') ? 'active' : '' }}">
                        <i class="ri-line-chart-line mr-3"></i>
                        <span>Report</span>
                    </a>
                </nav>
            </div>
            <!-- Logout Button -->
            <div class="p-4 border-t border-gray-700">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center w-full p-2 text-gray-200 rounded-md hover:bg-red-600 transition-colors duration-300">
                        <i class="ri-logout-box-line mr-3"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex-1 lg:pl-64">
            <!-- Mobile Header -->
            <div class="lg:hidden">
                <div class="bg-white shadow-md">
                    <div class="flex items-center justify-between px-4 py-3">
                        <button id="openMobileSidebar" class="text-gray-500 hover:text-gray-600">
                            <i class="ri-menu-line text-2xl"></i>
                        </button>
                        <div class="flex items-center">
                            <img class="h-8 w-8 rounded-full" src="https://picsum.photos/id/35/35" alt="User avatar">
                            <span class="ml-3 font-medium text-gray-700">{{ auth()->user()->name }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="py-6 px-4 sm:px-6 lg:px-8">
                @yield('dash')
            </div>
        </main>
    </div>

    <script>
        // Mobile sidebar toggle
        const mobileSidebar = document.getElementById('mobileSidebar');
        const openMobileSidebar = document.getElementById('openMobileSidebar');
        const closeMobileSidebar = document.getElementById('closeMobileSidebar');

        openMobileSidebar.addEventListener('click', () => {
            mobileSidebar.classList.remove('hidden');
        });

        closeMobileSidebar.addEventListener('click', () => {
            mobileSidebar.classList.add('hidden');
        });

        // Close sidebar when clicking outside
        mobileSidebar.addEventListener('click', (e) => {
            if (e.target === mobileSidebar) {
                mobileSidebar.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
