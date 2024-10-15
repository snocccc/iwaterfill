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
            transition: transform 0.3s ease;
            z-index: 50; /* Ensure sidebar is above other elements */
        }

        /* Sidebar hidden only on mobile */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }
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

        @media (max-width: 768px) {
            .sidebar-overlay {
                display: block;
                position: fixed;
                inset: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 40; /* Ensure overlay is above other elements */
                transition: opacity 0.3s ease;
                opacity: 0;
                pointer-events: none;
            }

            .sidebar-overlay.show {
                opacity: 1;
                pointer-events: auto;
            }
        }
    </style>
</head>
<body class="font-mont">

    <div class="flex flex-col lg:flex-row lg:min-h-screen">

        <!-- Mobile Menu Button -->
        <div class="p-4 bg-blue-600 text-white flex justify-between lg:hidden">
            <h1 class="text-2xl font-bold">iWaterFill</h1>
            <button id="menuButton" class="text-3xl">
                <i class="ri-menu-line"></i>
            </button>
        </div>

        <!-- Sidebar Overlay -->
        <div id="sidebar-overlay" class="sidebar-overlay lg:hidden"></div>

        <!-- Sidebar -->
        <div id="sidebar" class="sidebar fixed inset-y-0 left-0 w-64 lg:relative lg:flex lg:flex-col lg:shadow-md lg:overflow-y-auto">
            <div class="flex items-center justify-between p-4">
                <h1 class="text-white font-bold text-xl">iWaterFill</h1>
                <button id="closeSidebarButton" class="text-white text-2xl lg:hidden">
                    <i class="ri-close-line"></i>
                </button>
            </div>
            <div class="flex flex-col p-4 h-full">
                <nav class="space-y-2">
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
                    <a href="#" class="flex items-center p-3 text-gray-200 text-base rounded-lg">
                        <i class="ri-shopping-cart-line mr-3"></i>
                        <span>Order</span>
                    </a>
                    <div class="mt-auto pt-4 border-t border-gray-200">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center w-full p-3 text-gray-200 text-base rounded-lg hover:bg-red-600 transition-colors duration-300">
                                <i class="ri-logout-box-line mr-3"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </nav>

            </div>
        </div>

        <!-- Main Content -->
        <main class="flex-1 min-h-screen main-content">
            @yield('userDash')
        </main>
    </div>

    <script>
        const menuButton = document.getElementById('menuButton');
        const closeSidebarButton = document.getElementById('closeSidebarButton');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');

        menuButton.addEventListener('click', () => {
            sidebar.classList.toggle('show');
            sidebarOverlay.classList.toggle('show');
        });

        closeSidebarButton.addEventListener('click', () => {
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
        });

        sidebarOverlay.addEventListener('click', () => {
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
        });
    </script>

</body>
</html>
