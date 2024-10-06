<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css"
    rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css','resources/js/app.js'])
    <title>iWaterFill:</title>
</head>

<style>
    /* Add transition effects */
    button:hover, button:focus, input:hover, input:focus {
        transition: all 0.3s ease;
        transform: scale(1.05);
    }

    button:hover {
        background-color: #00509E;
    }

    .flex-row:hover img, .flex-row:hover h1 {
        transition: all 0.3s ease;
        transform: translateY(-10px);
    }

    .rounded-2xl:hover img {
        transition: all 0.3s ease;
        transform: scale(1.1);
    }

    .form-container:hover, .form-container:focus-within {
        transition: all 0.3s ease;
        box-shadow: 0px 0px 15px 5px rgba(0, 0, 0, 0.2);
    }
</style>

<body>
    <button class="flex flex-row">
        <a href="{{ route('login') }}">
            <img class="absolute mt-10 ml-[310px] sm:ml-[200px] md:ml-[100px] lg:ml-[310px]" src="resources\views\images\a.jpg" alt="">
            <h1 class="absolute text-3xl ml-[300px] sm:ml-[200px] md:ml-[100px] lg:ml-[310px] mt-5">iWaterFill</h1>
        </a>
    </button>

    <div class="h-screen w-screen bg-[#c9d6ff] bg-gradient-to-r from-[#e2e2e2] to-[#c9d6ff] flex justify-center items-center font-mont">
        @yield('auth')
    </div>
</body>
</html>
