@extends('layouts.admin')

@section('content')
    <header class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard Admin</h1>
        <p class="text-sm text-gray-500 mt-1">Ringkasan cepat sistem Digitalisasi Berita Acara</p>
    </header>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow flex flex-col">
            <span class="text-sm text-gray-500">Total Vendor</span>
            <span class="text-2xl font-semibold text-gray-800 mt-2">{{ $total_vendor }}</span>
        </div>

        <div class="bg-white p-4 rounded-lg shadow flex flex-col">
            <span class="text-sm text-gray-500">Total PIC Gudang</span>
            <span class="text-2xl font-semibold text-gray-800 mt-2">{{ $total_pic }}</span>
        </div>

        <div class="bg-white p-4 rounded-lg shadow flex flex-col">
            <span class="text-sm text-gray-500">Total Direksi</span>
            <span class="text-2xl font-semibold text-gray-800 mt-2">{{ $total_direksi }}</span>
        </div>

        <div class="bg-white p-4 rounded-lg shadow flex flex-col">
            <span class="text-sm text-gray-500">Total Dokumen BA</span>
            <span class="text-2xl font-semibold text-gray-800 mt-2">{{ $total_dokumen }}</span>
        </div>
    </div>

    <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white p-4 rounded-lg shadow">
            <h2 class="text-lg font-semibold mb-3">Recent Dokumen</h2>

            @if($latest_dokumen->isEmpty())
                <p class="text-sm text-gray-500">Tidak ada dokumen untuk ditampilkan.</p>
            @else
                <ul class="space-y-2">
                    @foreach($latest_dokumen as $d)
                        <li class="p-3 border rounded hover:bg-gray-50">
                            <div class="flex justify-between">
                                <div>
                                    <div class="font-medium">{{ $d->nama_vendor ?? '—' }}</div>
                                    <div class="text-sm text-gray-500">
                                        {{ $d->jenis_dokumen ?? '—' }} • {{ $d->nomor_kontrak ?? '-' }}
                                    </div>
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $d->created_at?->format('d M Y') ?? '-' }}
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <aside class="bg-white p-4 rounded-lg shadow">
            <h2 class="text-lg font-semibold mb-3">Quick Actions</h2>

            <div class="flex flex-col gap-2">
                <a href="{{ route('vendor.bapb.index') }}" class="block px-3 py-2 bg-blue-50 border rounded hover:bg-blue-100 text-blue-600 text-sm">
                    Buat BAPB Baru
                </a>
                <a href="{{ route('vendor.bapp.index') }}" class="block px-3 py-2 bg-green-50 border rounded hover:bg-green-100 text-green-700 text-sm">
                    Buat BAPP Baru
                </a>
                <a href="#" class="block px-3 py-2 bg-gray-50 border rounded hover:bg-gray-100 text-gray-700 text-sm">
                    Kelola User
                </a>
            </div>
        </aside>
    </section>
@endsection
