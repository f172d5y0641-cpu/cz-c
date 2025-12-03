<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'DigiBA') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/iconify/2.0.0/iconify.min.js"
        integrity="sha512-lYMiwcB608+RcqJmP93CMe7b4i9G9QK1RbixsNu4PzMRJMsqr/bUrkXUuFzCNsRUo3IXNUr5hz98lINURv5CNA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans">
    <div class="grid grid-cols-12 w-full h-screen">
        <div class="flex flex-col gap-4 items-start col-span-2 w-full h-full bg-[#264567] rounded-e-lg text-white p-2">
            <img src="{{ asset('logo.png') }}" alt="logo digiba" class="w-2/3">
            <div class="flex flex-col gap-2 w-full">
                <a href="{{ route('vendor.dashboard') }}"
                    class="text-xl flex px-8 py-4 gap-2 items-center rounded-lg hover:bg-white hover:text-[#264567]">
                    <i class="iconify" data-icon="material-symbols:home-outline-rounded"></i>
                    Dashboard
                </a>
                <a href="{{ route('vendor.bapb.create') }}"
                    class="text-xl flex px-8 py-4 gap-2 items-center rounded-lg hover:bg-white hover:text-[#264567]">
                    <i class="iconify" data-icon="uil:file-alt"></i>
                    Buat BAPB
                </a>
                <a href="{{ route('vendor.bapp.create') }}"
                    class="text-xl flex px-8 py-4 gap-2 items-center rounded-lg hover:bg-white hover:text-[#264567]">
                    <i class="iconify" data-icon="uil:file-alt"></i>
                    Buat BAPP
                </a>
                <a href="#"
                    class="text-xl flex px-8 py-4 gap-2 items-center rounded-lg hover:bg-white hover:text-[#264567]">
                    <i class="iconify" data-icon="akar-icons:gear"></i>
                    Pengaturan
                </a>
                <a href="{{ route('auth.logout') }}"
                    class="text-xl flex px-8 py-4 gap-2 items-center rounded-lg hover:bg-white hover:text-[#264567]">
                    <i class="iconify" data-icon="ic:round-log-out"></i>
                    Keluar
                </a>
            </div>
        </div>
        <div class="col-span-10 p-8 bg-gray-50">
            @if (session('success'))
                <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-rose-800">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-amber-800">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    @stack('modal')
    @stack('scripts')

    <script type="module" src='https://cdnjs.cloudflare.com/ajax/libs/pdf.js/4.0.269/pdf.min.mjs'></script>
    <script type="module" src='https://cdnjs.cloudflare.com/ajax/libs/pdf.js/4.0.269/pdf.worker.min.mjs'></script>
    <script src="https://cdn.jsdelivr.net/npm/interactjs@1.10.20/dist/interact.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@5.1.2/dist/signature_pad.umd.min.js"></script>
</body>

</html>
