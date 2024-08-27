@extends('components.layoutAuth')

@section('auth')

<section>


    <div class="w-[900px] h-[475px] bg-[#9EB7E5] bg-gradient-to-r from-[#9EB7E5] to-[#8DACE7] border rounded-[15px] flex items-center shadow-lg">
        <div class="w-1/2 m-[100px] sm:block hidden rounded-2xl">
            <img class="h-[200] w-[w-240px] pl-[90px]" src="a.jpg" alt="">
            <h1 class="text-4xl   m-3">iWaterFill:</h1>
            <h2 class="text-2xl">Water Refilling Station</h2>
        </div>

        <div class="bg-[#c9d6ff] w-1/2 m-4 h-[400px] border rounded-[14px] shadow-lg ">
            <h1 class="text-2xl font-bold ml-4 mt-2 text-[#002D74]">Login</h1>
            <p class="text-sm ml-4 mt-1">If You Already A Member, Please Login</p>
            <form action="" class="flex flex-col gap-4 mr-7 ml-7 ">
                <input class="p-1 mt-2 rounded-lg border" type="text" name="username" placeholder="Username">
                <div class="relative">
                    <input class="p-1 rounded-lg border w-full" type="text" name="password" placeholder="Password">
                    <i class="bi bi-eye absolute bottom-2 right-2 fill-red-400"></i>
                </div>
                <button class="bg-[#002D74] text-white border rounded-xl py-1">Login</button>
            </form>
            <div class="grid grid-cols-3 items-center">
                <hr class="border-gray-400">
                <p class="text-center text-gray-500">OR</p>
                <hr class="border-gray-400">
            </div>

            <button class="bg-white border py-1 w-full mt-1 rounded-xl flex justify-center items-center text-sm">
                <svg class="mr-3" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20px" height="20px" viewBox="0 0 48 48">
                    <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"></path><path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"></path><path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"></path><path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"></path>
                    </svg>
                Login With Google
            </button>

            <p class="text-sm mt-1 ml-5 border-b py-4 text-gray-700 mr-5 border-gray-700 flex items-center justify-center">
                <a href="#">Forgot Your Password?</a>
            </p>

            <div class="text-sm mt-1 ml-5 text-gray-700 mr-5 ">
                <p class="flex items-center justify-center">If You Don't Have An Account.</p>
            </div>

            <div class="flex items-center justify-center">
                <button class="px-5 py-1 bg-white flex justify-center border rounded-lg text-sm mt-2">Sign Up</button>
            </div>

        </div>
    </div>
</div>
</section>

@endsection
