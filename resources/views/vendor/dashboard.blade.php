@extends('layouts.vendor')
@section('content')
    <div class="grid grid-rows-5 grid-cols-12 gap-y-4">
        <div class="col-span-12 row-span-1 bg-white shadow-lg p-6 rounded-lg flex flex-col gap-4">
            <span class="font-semibold text-4xl text-gray-700">Selamat Datang, Vendor</span>
            <span class="text-xl text-gray-400">Kelola Berita Acara (BA) Anda di sini</span>
        </div>

        {{-- cards --}}
        <div class="row-span-1 col-span-12 grid grid-cols-12 gap-6">

            <a href="{{ route('vendor.bapb.index') }}"
                class="col-span-3 bg-white relative rounded-lg shadow-lg p-3 z-1 hover:scale-105 transition">
                <i class="iconify absolute w-1/2 h-full top-1/2 -translate-y-1/2 left-2 text-gray-300 -z-5"
                    data-icon="uil:file-alt"></i>
                <div class="flex flex-col gap-2 justify-center items-center h-full">
                    <span class="font-semibold text-xl">Total BAPB</span>
                    <span class="font-medium">{{ $totalBapb ?? 0 }} Dokumen</span>
                </div>
            </a>

            <a href="{{ route('vendor.bapp.index') }}"
                class="col-span-3 bg-white relative rounded-lg shadow-lg p-3 z-1 hover:scale-105 transition">
                <i class="iconify absolute w-1/2 h-full top-1/2 -translate-y-1/2 left-2 text-gray-300 -z-5"
                    data-icon="uil:file-alt"></i>
                <div class="flex flex-col gap-2 justify-center items-center h-full">
                    <span class="font-semibold text-xl">Total BAPP</span>
                    <span class="font-medium">{{ $totalBapp ?? 0 }} Dokumen</span>
                </div>
            </a>

            <div class="col-span-3 bg-white relative rounded-lg shadow-lg p-3 z-1">
                <i class="iconify absolute w-1/2 h-full top-1/2 -translate-y-1/2 left-2 text-gray-300 -z-5"
                    data-icon="mdi:file-sign"></i>
                <div class="flex flex-col gap-2 justify-center items-center h-full">
                    <span class="font-semibold text-xl">Menunggu Persetujuan</span>
                    <span class="font-medium">{{ $pending ?? 0 }} Dokumen</span>
                </div>
            </div>

            <div class="col-span-3 bg-white relative rounded-lg shadow-lg p-3 z-1">
                <i class="iconify absolute w-1/2 h-full top-1/2 -translate-y-1/2 left-2 text-gray-300 -z-5"
                    data-icon="mdi:file-check-outline"></i>
                <div class="flex flex-col gap-2 justify-center items-center h-full">
                    <span class="font-semibold text-xl">Disetujui</span>
                    <span class="font-medium">{{ $approved ?? 0 }} Dokumen</span>
                </div>
            </div>

        </div>


        {{-- Tables --}}
        <div class="col-span-12 row-span-3 bg-white rounded-lg shadow-lg p-6">
            <span class="text-gray-700 font-semibold text-3xl">Riwayat Berita Acara</span>

            <div class="grid grid-cols-12 gap-3 mt-2 items-center">
                <!-- Search -->
                <div class="col-span-4">
                    <input type="text" name="search" id="search" class="p-3 w-full border rounded-md border-gray-400"
                        placeholder="Cari nomor kontrak / vendor...">
                </div>

                <!-- Filter Jenis -->
                <div class="col-span-3">
                    <select name="jenis_dokumen" id="jenis_dokumen" class="p-3 w-full border rounded-md border-gray-400">
                        <option value="" disabled selected>Silahkan pilih jenis</option>
                        <option value="all">Semua Jenis</option>
                        <option value="bapp">BAPP</option>
                        <option value="bapb">BAPB</option>
                    </select>
                </div>

                <!-- Filter Status -->
                <div class="col-span-3">
                    <select name="status" id="status" class="p-3 w-full border rounded-md border-gray-400">
                        <option value="" disabled selected>Silahkan pilih status</option>
                        <option value="all">Semua Status</option>
                        <option value="pending">Pending</option>
                        <option value="submitted">Submitted</option>
                        <option value="approved">Accepted</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>

                <!-- Button Filter -->
                <div class="col-span-1">
                    <button
                        class="text-2xl border-0 w-full h-full p-2 bg-blue-200 text-blue-600 
                   hover:bg-blue-600 hover:text-blue-200 cursor-pointer rounded-md 
                   flex justify-center items-center"
                        onclick="filterData()">
                        <i class="iconify" data-icon="line-md:filter"></i>
                    </button>
                </div>

                <!-- Button Reset -->
                <div class="col-span-1">
                    <button
                        class="text-2xl border-0 w-full h-full p-2 bg-yellow-200 text-yellow-600 
                   hover:bg-yellow-600 hover:text-yellow-200 cursor-pointer rounded-md 
                   flex justify-center items-center"
                        onclick="resetFilter()">
                        <i class="iconify" data-icon="bx:reset"></i>
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto rounded-lg shadow-md mt-2">
                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr class="text-white">
                            <th class="bg-blue-200 text-blue-600 px-4 py-3 text-left font-semibold">No</th>
                            <th class="bg-blue-200 text-blue-600 px-4 py-3 text-left font-semibold">Nama Vendor</th>
                            <th class="bg-blue-200 text-blue-600 px-4 py-3 text-left font-semibold">Nomor Kontrak</th>
                            <th class="bg-blue-200 text-blue-600 px-4 py-3 text-left font-semibold">Jenis Dokumen</th>
                            <th class="bg-blue-200 text-blue-600 px-4 py-3 text-left font-semibold">
                                Nilai Pekerjaan (Rp)
                            </th>
                            <th class="bg-blue-200 text-blue-600 px-4 py-3 text-left font-semibold">Status</th>
                            <th class="bg-blue-200 text-blue-600 px-4 py-3 text-left font-semibold">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="text-gray-700">

                        @forelse ($dokumen as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3">{{ $item->nama_vendor ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $item->nomor_kontrak ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $item->jenis_dokumen }}</td>
                                <td class="px-4 py-3">{{ number_format($item->nilai_pekerjaan, 0, ',', '.') }}</td>
                                <td class="px-4 py-3">
                                    @php $status = $item->status ?? '-' ; @endphp

                                    @if ($item->status == 'pending')
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                            Pending
                                        </span>
                                    @elseif($item->status == 'submitted')
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-sky-100 text-sky-700">
                                            Submitted
                                        </span>
                                    @elseif($item->status == 'accepted')
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                            Accepted
                                        </span>
                                    @elseif($item->status == 'rejected')
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-700">
                                            Rejected
                                        </span>
                                    @else
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-200 text-gray-700">
                                            -
                                        </span>
                                    @endif
                                </td>

                                <td class="px-4 py-3 flex gap-2 flex-wrap">
                                    <a href="{{ isset($item->id_ba) ? route('vendor.dokumenba.show', $item->id_ba) : '#' }}"
                                        class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                                        Lihat detail
                                    </a>
                                    <a href="{{ isset($item->id_ba) ? route('vendor.dokumen.pdf.preview', $item->id_ba) : '#' }}"
                                        class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 text-sm">
                                        Preview PDF
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-6 text-gray-400">
                                    Belum ada data riwayat.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <script>
        function filterData() {
            const search = document.querySelector('#search').value;
            const jenis_dokumen = document.querySelector('#jenis_dokumen').value;
            const status = document.querySelector('#status').value;

            let redirectRoute = `{{ route('vendor.dashboard') }}?`

            if (search) {
                redirectRoute += `search=${search}&`
            }

            if (jenis_dokumen) {
                redirectRoute += `jenis_dokumen=${jenis_dokumen}&`
            }

            if (status) {
                redirectRoute += `status=${status}&`
            }

            window.location.href = redirectRoute
        }

        function resetFilter() {
            window.location.href = `{{ route('vendor.dashboard') }}`
        }
    </script>
@endsection
