@extends('layouts.picgudang')

@section('content')
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 row-span-1 bg-white shadow-lg p-6 rounded-lg flex flex-col gap-4">
            <span class="font-semibold text-4xl text-gray-700">Selamat Datang</span>
            <span class="text-xl text-gray-400">Lihat semua Berita Acara Pemeriksaan Barang (BAPB) di sini</span>
        </div>

        {{-- tables --}}
        <div class="col-span-12  bg-white rounded-lg shadow-lg p-6">
            <span class="text-gray-700 font-semibold text-3xl">Daftar BAPB</span>

            {{-- search & filter --}}
            <div class="flex items-center gap-4 mt-4">
                <div class="flex items-center gap-3 flex-none">
                    <input type="text" id="search" class="p-3 w-xs border rounded-md border-gray-400"
                        placeholder="Cari nomor kontrak / vendor...">
                    <button onclick="searchData()" class="h-12 px-4 bg-blue-500 text-white rounded hover:bg-blue-600 text-lg">Cari</button>
                </div>

                <div class="flex-grow"></div>

                <div class="flex-none w-60">
                    <select id="status" class="p-3 w-full border rounded-md border-gray-400 ml-auto">
                        <option >Pilih Status Dokumen</option>
                        <option value="all">Semua Status</option>
                        <option value="pending">Belum Diperiksa</option>
                        <option value="approved">Disetujui</option>
                        <option value="rejected">Ditolak</option>
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto rounded-lg shadow-md mt-4">
                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr class="text-white">
                            <th class="bg-blue-200 text-blue-600 px-4 py-3 text-left font-semibold">No</th>
                            <th class="bg-blue-200 text-blue-600 px-4 py-3 text-left font-semibold">Nomor Kontrak</th>
                            <th class="bg-blue-200 text-blue-600 px-4 py-3 text-left font-semibold">Nama Vendor</th>
                            <th class="bg-blue-200 text-blue-600 px-4 py-3 text-left font-semibold">Status</th>
                            <th class="bg-blue-200 text-blue-600 px-4 py-3 text-left font-semibold">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($bapb as $item)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3">{{ $item->nomor_kontrak ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $item->nama_vendor ?? '-' }}</td>

                                <td class="px-4 py-3">
                                    @if($item->status == 'pending')
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-sky-100 text-sky-700">
                                        Belum Diperiksa
                                    </span>
                                    @elseif($item->status == 'accepted')
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                        Disetujui
                                    </span>
                                    @elseif($item->status == 'rejected')
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-700">
                                        Ditolak
                                    </span>
                                    @else
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-200 text-gray-700">
                                        -
                                    </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 flex gap-2">
                                    @if($item->status == 'pending')
                                        {{-- lanjut periksa --}}
                                        <a href="{{ route('pic-gudang.bapb.detail-periksa', $item->id_ba) }}"
                                            class="px-3 py-1 rounded-md bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow">
                                            Periksa
                                        </a>

                                    @else
                                       {{-- lihat --}}
                                       <a href="{{ route('pic-gudang.bapb.show', $item->id_ba) }}"
                                            class="px-3 py-1 rounded-md bg-green-600 hover:bg-green-700 text-white text-xs font-semibold shadow">
                                            Lihat
                                       </a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-gray-500">
                                    Belum ada data BAPB.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
