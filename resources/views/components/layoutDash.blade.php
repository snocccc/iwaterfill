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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title>Purchase History</title>
</head>
<body class="bg-gray-100 font-mont">

    <div x-data="{ open: false }" class="flex flex-col lg:flex-row lg:min-h-screen">

        <!-- Sidebar -->
        <div :class="{'block': open, 'hidden': !open}" class="fixed inset-0 z-40 bg-gray-800 bg-opacity-75 lg:hidden" @click="open = false"></div>
        <div :class="{'translate-x-0': open, '-translate-x-full': !open}" class="fixed inset-y-0 left-0 w-48 bg-gray-900 transform transition-transform lg:relative lg:translate-x-0 lg:w-48 lg:flex lg:flex-col lg:shadow-md lg:overflow-y-auto z-50">
            <div class="flex items-center justify-between p-4 bg-gray-900 lg:hidden">
                <button @click="open = !open" class="text-white text-2xl">
                    <i class="ri-menu-line"></i>
                </button>
            </div>
            <div class="flex flex-col p-2 h-full lg:h-auto">
                <a href="#" class="flex items-center pb-2 border-b border-gray-200">
                    <img class="w-12 h-12 rounded object-cover" src="a.jpg" alt="">
                    <h1 class="text-white font-bold text-xl ml-2">iWaterFill</h1>
                </a>
                <ul class="mt-2 space-y-2 overflow-y-auto lg:overflow-y-auto">
                    <li>
                        <a href="{{ route('dashboard') }}" class="flex items-center p-2 text-gray-200 text-base hover:bg-gray-700 hover:text-gray-100 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-gray-600 text-white' : '' }}">
                            <i class="ri-home-8-line mr-2"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('purchase') }}" class="flex items-center p-2 text-gray-200 text-base hover:bg-gray-700 hover:text-gray-100 rounded-lg {{ request()->routeIs('purchase') ? 'bg-gray-600 text-white' : '' }}">
                            <i class="bi bi-bag-fill mr-2"></i>
                            <span>Add Purchase</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('customerList') }}" class="flex items-center p-2 text-gray-200 text-base hover:bg-gray-700 hover:text-gray-100 rounded-lg {{ request()->routeIs('customerList') ? 'bg-gray-600 text-white' : '' }}">
                            <i class="ri-id-card-line mr-2"></i>
                            <span>Customer List</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('addProduct') }}" class="flex items-center p-2 text-gray-200 text-base hover:bg-gray-700 hover:text-gray-100 rounded-lg {{ request()->routeIs('addProduct') ? 'bg-gray-600 text-white' : '' }}">
                            <i class="bi bi-receipt-cutoff mr-2"></i>
                            <span>Add Product</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('history') }}" class="flex items-center p-2 text-gray-200 text-base hover:bg-gray-700 hover:text-gray-100 rounded-lg {{ request()->routeIs('history') ? 'bg-gray-600 text-white' : '' }}">
                            <i class="bi bi-clock-history mr-2"></i>
                            <span>Purchase History</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('container') }}" class="flex items-center p-2 text-gray-200 text-base hover:bg-gray-700 hover:text-gray-100 rounded-lg {{ request()->routeIs('availableContainer') ? 'bg-gray-600 text-white' : '' }}">
                            <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" height="24" width="24" viewBox="0 0 512 512"><path fill="currentColor" d="M225 25v30h62V25zm8 48v28.6l-5 2.5c-17 8.5-40.6 16.3-59.4 27.6c-9.6 5.8-17.6 12-23.2 19.3h221.2c-5.6-7.3-13.6-13.5-23.2-19.3c-18.8-11.3-42.4-19.1-59.4-27.6l-5-2.5V73zm-112 96v16h270v-16zm16 34v28h238v-28zm-16 46v30h270v-30zm16 48v94h238v-94zm0 112v39c0 1 1.1 4.9 4 9.3c2.9 4.3 7.4 9.3 12.8 13.8c10.8 9 25.2 15.9 38.2 15.9h128c13 0 27.4-6.9 38.2-15.9c5.4-4.5 9.9-9.5 12.8-13.8c2.9-4.4 4-8.3 4-9.3v-39z"/></svg>
                            <span>Available Container</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center p-2 text-gray-200 text-base hover:bg-gray-700 hover:text-gray-100 rounded-lg {{ request()->routeIs('report') ? 'bg-gray-600 text-white' : '' }}">
                            <i class="ri-line-chart-fill mr-2"></i>
                            <span>Report</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex-1 bg-blue-200 bg-gradient-to-r from-[#e2e2e2] to-[#c9d6ff] min-h-screen lg:ml-0 lg:pl-0 lg:py-0">
            <div class="flex items-center justify-between p-4 bg-blue-200 lg:hidden">
                <button class="text-3xl text-gray-700" @click="open = !open">
                    <i class="ri-menu-line"></i>
                </button>
                <div class="relative grid place-items-center">
                    <button type="button" class="rounded-full overflow-hidden" @click="open = !open">
                        <img src="https://picsum.photos/id/35/35" alt="">
                    </button>
                    <div class="bg-white shadow-lg absolute rounded-lg overflow-hidden mt-12 right-0" x-show="open" @click.outside="open = false">
                        <p class="font-light pl-4 w-full">{{ auth()->user()->username }}</p>
                        <hr class="border-gray-300">
                        <a class="block hover:bg-slate-100 pr-4 mb-1 pl-4" @click="open = false">Dashboard</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="block hover:bg-slate-100 pr-4 mb-1 pl-4 w-full" @click="open = false">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
            @yield('dash')
        </main>
    </div>

</body>
</html>
