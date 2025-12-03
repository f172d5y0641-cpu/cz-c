@extends('layouts.direksi')

@section('content')
    <div class="grid grid-rows-5 grid-cols-12 gap-y-4">

        {{-- Header --}}
        <div class="col-span-12 row-span-1 bg-white shadow-lg p-6 rounded-lg flex flex-col gap-4">
            <span class="font-semibold text-4xl text-gray-700">Selamat Datang, Direksi</span>
            <span class="text-xl text-gray-400">Kelola dan pantau Berita Acara (BA) di sini</span>
        </div>

        {{-- Cards --}}
        <div class="row-span-1 col-span-12 grid grid-cols-12 gap-6">
            <div class="col-span-3 bg-white relative rounded-lg shadow-lg p-3 z-1 hover:scale-105 transition">
                <i class="iconify absolute w-1/2 h-full top-1/2 -translate-y-1/2 left-2 text-gray-300 -z-5"
                    data-icon="uil:file-alt"></i>
                <div class="flex flex-col gap-2 justify-center items-center h-full">
                    <span class="font-semibold text-xl">Total BAPP</span>
                    <span class="font-medium">{{ $totalBapp ?? 0 }} Dokumen</span>
                </div>
            </div>

            <div class="col-span-3 bg-white relative rounded-lg shadow-lg p-3 z-1 hover:scale-105 transition">
                <i class="iconify absolute w-1/2 h-full top-1/2 -translate-y-1/2 left-2 text-gray-300 -z-5"
                    data-icon="mdi:file-sign"></i>
                <div class="flex flex-col gap-2 justify-center items-center h-full">
                    <span class="font-semibold text-xl">Pending</span>
                    <span class="font-medium">{{ $pending ?? 0 }} Dokumen</span>
                </div>
            </div>

            <div class="col-span-3 bg-white relative rounded-lg shadow-lg p-3 z-1 hover:scale-105 transition">
                <i class="iconify absolute w-1/2 h-full top-1/2 -translate-y-1/2 left-2 text-gray-300 -z-5"
                    data-icon="mdi:file-check-outline"></i>
                <div class="flex flex-col gap-2 justify-center items-center h-full">
                    <span class="font-semibold text-xl">Disetujui</span>
                    <span class="font-medium">{{ $approved ?? 0 }} Dokumen</span>
                </div>
            </div>

            <div class="col-span-3 bg-white relative rounded-lg shadow-lg p-3 z-1 hover:scale-105 transition">
                <i class="iconify absolute w-1/2 h-full top-1/2 -translate-y-1/2 left-2 text-gray-300 -z-5"
                    data-icon="mdi:file-cancel"></i>
                <div class="flex flex-col gap-2 justify-center items-center h-full">
                    <span class="font-semibold text-xl">Ditolak</span>
                    <span class="font-medium">{{ $rejected ?? 0 }} Dokumen</span>
                </div>
            </div>

        </div>

        {{-- Tabel Riwayat --}}
        <div class="col-span-12 row-span-3 bg-white rounded-lg shadow-lg p-6">
            <span class="text-gray-700 font-semibold text-3xl">Riwayat Berita Acara</span>  
            <table class="w-full table-auto border-collapse mt-2">
                <thead>
                    <tr class="text-white">
                        <th class="bg-blue-200 text-blue-600 px-4 py-3 text-left font-semibold">No</th>
                        <th class="bg-blue-200 text-blue-600 px-4 py-3 text-left font-semibold">Nama Vendor</th>
                        <th class="bg-blue-200 text-blue-600 px-4 py-3 text-left font-semibold">Nomor Kontrak</th>
                        <th class="bg-blue-200 text-blue-600 px-4 py-3 text-left font-semibold">Jenis Dokumen</th>
                        <th class="bg-blue-200 text-blue-600 px-4 py-3 text-left font-semibold">Nilai Pekerjaan (Rp)</th>
                        <th class="bg-blue-200 text-blue-600 px-4 py-3 text-left font-semibold">Status</th>
                        <th class="bg-blue-200 text-blue-600 px-4 py-3 text-left font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700">
                    @forelse ($dokumen as $item)
                        @php $status = $item->status ?? '-' ; @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3">{{ $item->nama_vendor ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $item->nomor_kontrak ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $item->jenis_dokumen }}</td>
                            <td class="px-4 py-3">{{ number_format($item->nilai_pekerjaan, 0, ',', '.') }}</td>
                            <td class="px-4 py-3">
                                @if ($status == 'pending')
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">Pending</span>
                                @elseif($status == 'submitted')
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-semibold bg-sky-100 text-sky-700">Submitted</span>
                                @elseif($status == 'accepted' || $status == 'approved')
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">Accepted</span>
                                @elseif($status == 'rejected')
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-700">Rejected</span>
                                @else
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-200 text-gray-700">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 flex gap-2 flex-wrap">
                                <a href="{{ route('direksi.bapp.detail', $item->id_ba) }}"
                                    class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">Lihat
                                    detail</a>
                                @if ($status == 'accepted' || $status == 'approved')
                                    <a href="{{ route('bapp.print', $item->id_ba) }}" target="_blank"
                                        class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 text-sm">Preview
                                        PDF</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-6 text-gray-400">Belum ada data riwayat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if ($totalBapp > 5)
                <div class="mt-4 flex justify-end px-4">
                    <a href="{{ route('direksi.riwayat') }}"
                        class="text-gray-500 underline hover:text-gray-700 transition font-semibold text-base">
                        Lihat Semua Riwayat
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
