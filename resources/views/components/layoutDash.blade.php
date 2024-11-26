<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">

    <title>@yield('title', 'Default Title')</title>

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
            height: 100vh;
            overflow: hidden;
        }

        .sidebar {
            background-color: var(--color-dark-blue);
            transition: transform 0.3s ease;
            z-index: 60;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            position: sticky;
            top: 0;
            background-color: var(--color-dark-blue);
            z-index: 61;
            padding: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-content {
            flex: 1;
            overflow-y: auto;
        }

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
            pointer-events: none;
        }

        .sidebar-header .flex {
    gap: 1rem; /* Adds space between logo and the name */
}


        .main-content {
            background: linear-gradient(to right, var(--color-very-light-blue), var(--color-pale-blue));
            overflow-y: auto;
            height: 100vh;
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

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 50;
            transition: opacity 0.3s ease;
            opacity: 0;
            pointer-events: none;
        }

        .sidebar-overlay.show {
            display: block;
            opacity: 1;
            pointer-events: auto;
        }

        .logout-container {
            position: sticky;
            bottom: 0;
            background-color: var(--color-dark-blue);
            padding: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="font-mont">
    <div class="flex flex-col lg:flex-row h-screen">
        <div class="p-4 bg-blue-600 text-white flex justify-between lg:hidden">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-8 h-8 ml-10">
            <h1 class="text-2xl font-bold">Lola A's Tubigan</h1>
            <button id="menuButton" class="text-3xl">
                <i class="ri-menu-line"></i>
            </button>
        </div>

        <div id="sidebar-overlay" class="sidebar-overlay lg:hidden"></div>

        <div id="sidebar" class="sidebar fixed inset-y-0 left-0 w-64 lg:relative">
            <div class="sidebar-header">
                <div class="flex items-center justify-between">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-8 h-8">
                    <h1 class="text-white font-bold text-xl mr-5">Lola A's Tubigan</h1>
                    <button id="closeSidebarButton" class="text-white text-2xl lg:hidden">
                        <i class="ri-close-line"></i>
                    </button>
                </div>
            </div>

            <div class="sidebar-content">
                <nav class="p-4 space-y-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center p-3 text-gray-200 rounded-lg {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="ri-home-8-line mr-3"></i> Dashboard
                    </a>
                    <a href="{{ route('purchase') }}" class="flex items-center p-3 text-gray-200 rounded-lg {{ request()->routeIs('purchase') ? 'active' : '' }}">
                        <i class="ri-shopping-cart-line mr-3"></i> POS
                    </a>
                    <a href="{{ route('order') }}" class="flex items-center p-3 text-gray-200 rounded-lg {{ request()->routeIs('order') ? 'active' : '' }}">
                        <i class="ri-check-line mr-3"></i> Online Orders
                    </a>
                    <a href="{{ route('container') }}" class="flex items-center p-3 text-gray-200 rounded-lg {{ request()->routeIs('container') ? 'active' : '' }}">
                        <i class="ri-inbox-line mr-3"></i> Inventory
                    </a>
                    <a href="{{ route('customerList') }}" class="flex items-center p-3 text-gray-200 rounded-lg {{ request()->routeIs('customerList') ? 'active' : '' }}">
                        <i class="ri-user-line mr-3"></i> Customer List
                    </a>
                    <a href="{{ route('history') }}" class="flex items-center p-3 text-gray-200 rounded-lg {{ request()->routeIs('history') ? 'active' : '' }}">
                        <i class="ri-time-line mr-3"></i> Transaction History
                    </a>
                    <a href="{{ route('settings') }}" class="flex items-center p-3 text-gray-200 rounded-lg {{ request()->routeIs('settings') ? 'active' : '' }}">
                        <i class="ri-settings-2-line mr-3"></i> Settings
                    </a>

                </nav>
            </div>

            <div class="logout-container">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center w-full p-3 text-gray-200 text-base rounded-lg hover:bg-red-600 transition-colors duration-300">
                        <i class="ri-logout-box-line mr-3"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>



        <main class="flex-1 main-content bg-gradient-to-br from-blue-50 to-cyan-50">
            @yield('dash')
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
