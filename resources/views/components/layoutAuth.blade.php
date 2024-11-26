<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css"
    rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css','resources/js/app.js'])
  <title>@yield('title', 'Default Title')</title>
</head>

<style>
    :root {
        --color-dark-blue: #03045E;
        --color-medium-blue: #0077B6;
        --color-light-blue: #00B4D8;
        --color-very-light-blue: #90E0EF;
        --color-pale-blue: #CAF0F8;
    }
</style>

<body>



     @yield('auth')

</body>
</html>
