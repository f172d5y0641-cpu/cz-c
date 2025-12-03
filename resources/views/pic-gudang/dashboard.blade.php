@extends('layouts.picgudang')
@section('content')
    <div class="grid grid-rows-5 grid-cols-12 gap-y-4">
        <div class="col-span-12 row-span-1 bg-white shadow-lg p-6 rounded-lg flex flex-col gap-4">
            <span class="font-semibold text-4xl text-gray-700">Selamat Datang, PIC Gudang</span>
            <span class="text-xl text-gray-400">Kelola Pemeriksaan Berita Acara Pemeriksaan Barang(BAPB) Anda di sini</span>
        </div>

        {{-- cards 1 --}}
        <div class="row-span-1 col-span-12 grid grid-cols-12 gap-6">

            <a href="{{ route('pic-gudang.bapb.index') }}"
                class="col-span-3 bg-white relative rounded-lg shadow-lg p-3 z-1 hover:scale-105 transition">
                <i class="iconify absolute w-1/2 h-full top-1/2 -translate-y-1/2 left-2 text-gray-300 -z-5"
                    data-icon="uil:file-alt"></i>
                <div class="flex flex-col gap-2 justify-center items-center h-full">
                    <span class="font-semibold text-xl">Total BAPB</span>
                    <span class="font-medium">{{ $totalBapb ?? 0 }} Dokumen</span>
                </div>
            </a>
            <a href="{{ route('pic-gudang.bapb.periksa') }}"
                class="col-span-3 bg-white relative rounded-lg shadow-lg p-3 z-1 hover:scale-105 transition">
                <i class="iconify absolute w-1/2 h-full top-1/2 -translate-y-1/2 left-2 text-gray-300 -z-5"
                    data-icon="mdi:file-sign"></i>
                <div class="flex flex-col gap-2 justify-center items-center h-full">
                    <span class="font-semibold text-xl">Belum Diperiksa</span>
                    <span class="font-medium">{{ $belumDiperiksa ?? 0 }} Dokumen</span>
                </div>
            </a>
            <div class="col-span-3 bg-white relative rounded-lg shadow-lg p-3 z-1">
                <i class="iconify absolute w-1/2 h-full top-1/2 -translate-y-1/2 left-2 text-gray-300 -z-5"
                    data-icon="mdi:file-check-outline"></i>
                <div class="flex flex-col gap-2 justify-center items-center h-full">
                    <span class="font-semibold text-xl">Disetujui</span>
                    <span class="font-medium">{{ $disetujui ?? 0 }} Dokumen</span>
                </div>
            </div>
            <div class="col-span-3 bg-white relative rounded-lg shadow-lg p-3 z-1">
                <i class="iconify absolute w-1/2 h-full top-1/2 -translate-y-1/2 left-2 text-gray-300 -z-5"
                    data-icon="mdi:file-remove-outline"></i>
                <div class="flex flex-col gap-2 justify-center items-center h-full">
                    <span class="font-semibold text-xl">Ditolak</span>
                    <span class="font-medium">{{ $ditolak ?? 0 }} Dokumen</span>
                </div>
            </div>
        </div>

        {{-- cards 2 --}}
        <div class="col-span-12 grid grid-cols-12 gap-6 mt-2">
            <div class="col-span-6 bg-white rounded-xl p-6 shadow-md hover:-translate-y-1 hover:shadow-lg transition">
                <h3 class="text-lg font-bold text-slate-800 mb-3">💡 Tips Penggunaan</h3>
                <p class="text-slate-600 text-m">
                    Klik menu <strong>Periksa BAPB</strong> untuk melihat kumpulan dokumen yang belum diperiksa.
                </p>
            </div>

            <div class="col-span-6 bg-white rounded-xl p-6 shadow-md hover:-translate-y-1 hover:shadow-lg transition">
                <h3 class="text-lg font-bold text-slate-800 mb-3">📊 Progress Pemeriksaan</h3>
                <div class="w-full h-2 bg-slate-200 rounded-md overflow-hidden mb-2">
                    <div class="h-full bg-gradient-to-r from-blue-500 to-cyan-400"
                        style="width: {{ $progres }}%;">
                    </div>
                </div>
                <p class="text-slate-600 text-m">{{ $progres }}% dokumen telah diperiksa</p>
            </div>
        </div>
    </div>
@endsection
