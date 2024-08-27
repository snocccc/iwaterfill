<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css"rel="stylesheet"/>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css','resources/js/app.js'])
    <title>Document</title>
</head>
<body>

    <div class="fixed left-0 top-0 w-64 h-full bg-gray-900">
        <a href="#" class="flex items-center pb-4 border-b border-b-gray-200">
            <img class="w-[60px] h-[60px] rounded object-cover m-3" src="a.jpg" alt="">
            <h1 class="text-white font-bold text-2xl">iWaterFill:</h1>
        </a>

        <ul class="mt-4">
            <li class="mb-4">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center py-2 px-4 mr-3 ml-3 text-gray-200 text-2xl
                          hover:bg-gray-950 hover:text-gray-100 rounded-xl
                          {{ request()->routeIs('dashboard') ? 'bg-gray-600 text-white' : '' }}">
                    <i class="ri-home-8-line mr-4 ml-3"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="mb-4">
                <a href="{{ route('payment') }}"
                   class="flex items-center py-2 px-4 text-gray-200 text-xl
                          hover:bg-gray-950 hover:text-gray-100 rounded-md
                          {{ request()->routeIs('payment') ? 'bg-gray-800 text-white' : '' }}">
                    <i class="bi bi-bag-fill mr-4 ml-3"></i>
                    <span>ADD PURCHASE</span>
                </a>
            </li>

            <li class="mb-4">
                <a href="{{ route('customerList') }}"
                   class="flex items-center py-2 px-4 text-gray-200 text-xl
                          hover:bg-gray-950 hover:text-gray-100 rounded-md
                          {{ request()->routeIs('customerList') ? 'bg-gray-800 text-white' : '' }}">
                    <i class="ri-id-card-line mr-4 ml-3"></i>
                    <span>CUSTOMER LIST</span>
                </a>
            </li>

            <li class="mb-4">
                <a href="{{ route('addProduct') }}"
                   class="flex items-center py-2 px-4 text-gray-200 text-xl
                          hover:bg-gray-950 hover:text-gray-100 rounded-md
                          {{ request()->routeIs('addProduct') ? 'bg-gray-800 text-white' : '' }}">
                    <i class="bi bi-receipt-cutoff mr-4 ml-3"></i>
                    <span>ADD PRODUCT</span>
                </a>
            </li>

            <li class="mb-4">
                <a href="#"
                   class="flex items-center py-2 px-4 text-gray-200 text-xl
                          hover:bg-gray-950 hover:text-gray-100 rounded-md
                          {{ request()->routeIs('onlineOrders') ? 'bg-gray-800 text-white' : '' }}">
                    <i class="bi bi-receipt-cutoff mr-4 ml-3"></i>
                    <span>ONLINE ORDERS</span>
                </a>
            </li>

            <li class="mb-4">
                <a href="#"
                   class="flex items-center py-2 px-4 text-gray-200 text-xl
                          hover:bg-gray-950 hover:text-gray-100 rounded-md
                          {{ request()->routeIs('purchaseHistory') ? 'bg-gray-800 text-white' : '' }}">
                    <i class="bi bi-clock-history mr-4 ml-3"></i>
                    <span>PURCHASE HISTORY</span>
                </a>
            </li>

            <li class="mb-4">
                <a href="#"
                   class="flex items-center py-2 px-4 text-gray-200 text-xl
                          hover:bg-gray-950 hover:text-gray-100 rounded-md
                          {{ request()->routeIs('availableContainer') ? 'bg-gray-800 text-white' : '' }}">
                    <svg class="mr-3"
                         xmlns="http://www.w3.org/2000/svg"
                         height="40"
                         width="40"
                         style="color: #eff1f5; background: none;"
                         viewBox="0 0 512 512">
                        <path fill="currentColor" d="M225 25v30h62V25zm8 48v28.6l-5 2.5c-17 8.5-40.6 16.3-59.4 27.6c-9.6 5.8-17.6 12-23.2 19.3h221.2c-5.6-7.3-13.6-13.5-23.2-19.3c-18.8-11.3-42.4-19.1-59.4-27.6l-5-2.5V73zm-112 96v16h270v-16zm16 34v28h238v-28zm-16 46v30h270v-30zm16 48v94h238v-94zm0 112v39c0 1 1.1 4.9 4 9.3c2.9 4.3 7.4 9.3 12.8 13.8c10.8 9 25.2 15.9 38.2 15.9h128c13 0 27.4-6.9 38.2-15.9c5.4-4.5 9.9-9.5 12.8-13.8c2.9-4.4 4-8.3 4-9.3v-39z"/>
                    </svg>
                    <span>AVAILABLE CONTAINER</span>
                </a>
            </li>

            <li class="mb-4">
                <a href="#"
                   class="flex items-center py-2 px-4 text-gray-200 text-xl
                          hover:bg-gray-950 hover:text-gray-100 rounded-md
                          {{ request()->routeIs('report') ? 'bg-gray-800 text-white' : '' }}">
                    <i class="ri-line-chart-fill mr-4 ml-3"></i>
                    <span>REPORT</span>
                </a>
            </li>

        </ul>

    </div>

    <main class="w-[calc(100%-256px)] ml-64 bg-blue-200 bg-gradient-to-r from-[#e2e2e2] to-[#c9d6ff] min-h-screen">
        <div class="py-2 px-4 bg-white flex items-center shadow-md shadow-black/30">
            <button class="text-3xl text-gray-700">
                <i class="ri-menu-line mr-3"></i>
            </button>

            <ul class="flex items-center text-3xl">
                <li>
                    <a href="#" class="text-gray-400 hover:text-gray-700 flex ">Dashboard</a>
                </li>
                <li class="text-gray-700 ml-4">/</li>
                <li class="text-gray-700 ml-4"> Analytics</li>
            </ul>

            <div class="relative grid place-items-center ml-auto"
            x-data="{ open:false}">
                <button type="button" class="rounded-full overflow-auto"
                @click="open=!open">
                    <img src="https://picsum.photos/id/35/35" alt="">
                </button>

                <div class="bg-white shadow-lg absolute rounded-lg overflow-hidden mt-[100px] mr-[115px]"
                x-show="open" @click.outside="open=false">
                    <p class="font-light pl-4 w-full">{{ auth()->user()->username }}</p>
                    <hr class="border-gray-300">
                    <a class="block hover:bg-slate-100 pr-4 mb-1 pl-4">
                        Dashboard
                    </a>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="block hover:bg-slate-100 pr-4 mb-1 pl-4 w-full">Logout</button>
                    </form>

                </div>
            </div>

        </div>

        @yield('dash')
    </main>

</body>
</html>
