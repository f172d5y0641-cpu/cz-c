<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin – {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/iconify/2.0.0/iconify.min.js"
        integrity="sha512-lYMiwcB608+RcqJmP93CMe7b4i9G9QK1RbixsNu4PzMRJMsqr/bUrkXUuFzCNsRUo3IXNUr5hz98lINURv5CNA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans bg-gray-100">

    <div class="grid grid-cols-12 w-full">
        
        <!-- Sidebar Admin -->
        <div class="flex flex-col gap-4 items-start col-span-2 w-full h-screen bg-[#3B5A7A] text-white p-4">

            <img src="{{ asset('logo.png') }}" alt="logo digiba" class="w-2/3 mb-4">

            <div class="flex flex-col gap-2 w-full">

                <a href="{{ route('admin.dashboard') }}"
                    class="text-lg flex px-6 py-3 gap-2 items-center rounded-lg hover:bg-white hover:text-[#3B5A7A]">
                    <i class="iconify" data-icon="material-symbols:home-outline-rounded"></i>
                    Dashboard
                </a>

                <a href="{{ route('admin.users.index') }}"
                    class="text-lg flex px-6 py-3 gap-2 items-center rounded-lg hover:bg-white hover:text-[#3B5A7A]">
                    <i class="iconify" data-icon="uil:users-alt"></i>
                    Kelola User
                </a>

                <a href="{{ route('admin.dokumen-ba.index') }}"
                    class="text-lg flex px-6 py-3 gap-2 items-center rounded-lg hover:bg-white hover:text-[#3B5A7A]">   
                    <i class="iconify" data-icon="uil:file-check"></i>
                    Semua Dokumen BA
                </a>

                <a href="{{ route('auth.logout') }}"
                    class="text-lg flex px-6 py-3 gap-2 items-center rounded-lg hover:bg-white hover:text-[#3B5A7A] mt-4">
                    <i class="iconify" data-icon="ic:round-log-out"></i>
                    Keluar
                </a>
            </div>
        </div>

        <!-- Konten -->
        <div class="col-span-10 p-8 bg-gray-50 min-h-screen">
            @yield('content')
        </div>

    </div>

</body>

</html>
