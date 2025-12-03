<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-200 w-screen h-screen flex justify-center items-center">

    <div class="bg-white p-8 shadow-lg rounded-lg w-1/4">

        <form action="{{ route('auth.login') }}" method="POST" class="flex flex-col gap-4">
            @csrf

            <h2 class="text-center font-semibold text-3xl">Sign In</h2>

            <div class="flex flex-col gap-2">
                <label>Email</label>
                <input type="email" name="email" class="w-full px-3 py-2 rounded-lg border border-gray-400"
                    required>
            </div>

            <div class="flex flex-col gap-2">
                <label>Password</label>
                <input type="password" name="password" class="w-full px-3 py-2 rounded-lg border border-gray-400"
                    required>
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Login
            </button>

        </form>

    </div>

</body>

</html>
