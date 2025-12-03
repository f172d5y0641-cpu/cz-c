<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/iconify/2.0.0/iconify.min.js"
        integrity="sha512-lYMiwcB608+RcqJmP93CMe7b4i9G9QK1RbixsNu4PzMRJMsqr/bUrkXUuFzCNsRUo3IXNUr5hz98lINURv5CNA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans">
    <div class="grid grid-cols-12 w-full min-h-screen">
        <div class="flex flex-col gap-4 items-start col-span-2 w-full h-full bg-[#264567] rounded-e-lg text-white p-2">
            <img src="{{ asset('logo.png') }}" alt="logo digiba" class="w-2/3">
            <div class="flex flex-col gap-2 w-full">
                <a href="{{ route('pic-gudang.dashboard') }}"
                    class="text-xl flex px-8 py-4 gap-2 items-center rounded-lg {{ request()->routeIs('pic-gudang.dashboard')? 'bg-white text-[#264567]': 'hover:bg-white hover:text-[#264567]' }}">
                    <i class="iconify" data-icon="material-symbols:home-outline-rounded"></i>
                    Dashboard
                </a>
                <a href="{{ route('pic-gudang.bapb.index') }}"
                    class="text-xl flex px-8 py-4 gap-2 items-center rounded-lg {{ request()->routeIs('pic-gudang.bapb.index')? 'bg-white text-[#264567]': 'hover:bg-white hover:text-[#264567]' }}">
                    <i class="iconify" data-icon="uil:file-alt"></i>
                    Daftar BAPP
                </a>
                <a href="{{ route('pic-gudang.bapb.periksa') }}"
                    class="text-xl flex px-8 py-4 gap-2 items-center rounded-lg {{ request()->routeIs('pic-gudang.bapb.periksa', 'pic-gudang.bapb.detail-periksa')? 'bg-white text-[#264567]': 'hover:bg-white hover:text-[#264567]' }}">
                    <i class="iconify" data-icon="ic:outline-fact-check"></i>
                    Periksa BAPB
                </a>
                <a href="{{ route('pic-gudang.signature.create') }}"
                    class="text-xl flex px-8 py-4 gap-2 items-center rounded-lg {{ request()->routeIs('pic-gudang.signature.create')? 'bg-white text-[#264567]': 'hover:bg-white hover:text-[#264567]' }}">
                    <i class="iconify" data-icon="fluent:signature-24-regular"></i>
                    Tanda Tangan
                </a>
                <a href="{{ route('auth.logout') }}"
                    class="text-xl flex px-8 py-4 gap-2 items-center rounded-lg hover:bg-white hover:text-[#264567]">
                    <i class="iconify" data-icon="ic:round-log-out"></i>
                    Keluar
                </a>
            </div>
        </div>
        <div class="col-span-10 p-8 bg-gray-50">
            @yield('content')
        </div>
    </div>
</body>

</html>
