<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Direksi - {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/iconify/2.0.0/iconify.min.js" crossorigin="anonymous"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans">
    <div class="flex w-full min-h-screen">

        {{-- SIDEBAR DIREKSI --}}
        <div class="flex flex-col gap-4 items-start w-64 h-screen bg-[#264567] text-white p-4 fixed">
            <img src="{{ asset('logo.png') }}" class="w-2/3 mb-6">

            <a href="{{ route('direksi.dashboard') }}"
                class="text-lg flex px-6 py-3 gap-2 items-center rounded-lg hover:bg-white hover:text-[#264567]">
                <i class="iconify" data-icon="material-symbols:home-outline-rounded"></i>
                Dashboard
            </a>

            <a href="{{ route('direksi.bapp.index') }}"
                class="text-lg flex px-6 py-3 gap-2 items-center rounded-lg hover:bg-white hover:text-[#264567]">
                <i class="iconify" data-icon="uil:file-alt"></i>
                Daftar BAPP
            </a>

            <a href="{{ route('direksi.riwayat') }}"
                class="text-lg flex px-6 py-3 gap-2 items-center rounded-lg hover:bg-white hover:text-[#264567]">
                <i class="iconify" data-icon="mdi:history"></i>
                Riwayat BAPP
            </a>

            <a href="{{ route('auth.logout') }}"
                class="text-lg flex px-6 py-3 gap-2 items-center rounded-lg hover:bg-white hover:text-[#264567]">
                <i class="iconify" data-icon="ic:round-log-out"></i>
                Keluar
            </a>
        </div>

        {{-- KONTEN --}}
        <div class="flex-1 ml-64 p-8 bg-gray-50 min-h-screen overflow-y-auto">
            @yield('content')
        </div>

        @stack('modal')
        @stack('scripts')

        <script type="module" src='https://cdnjs.cloudflare.com/ajax/libs/pdf.js/4.0.269/pdf.min.mjs'></script>
        <script type="module" src='https://cdnjs.cloudflare.com/ajax/libs/pdf.js/4.0.269/pdf.worker.min.mjs'></script>
        <script src="https://cdn.jsdelivr.net/npm/interactjs@1.10.20/dist/interact.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/signature_pad@5.1.2/dist/signature_pad.umd.min.js"></script>

    </div>
</body>


</html>
