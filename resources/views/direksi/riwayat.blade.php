@extends('layouts.direksi')

@section('content')
    <div class="grid grid-rows-5 grid-cols-12 gap-y-4">

        {{-- Tabel Riwayat dengan Search --}}
        <div class="col-span-12 row-span-4 bg-white rounded-lg shadow-lg p-6">

            {{-- Header --}}
            <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 gap-2">
                <span class="text-gray-700 font-semibold text-2xl">Riwayat Berita Acara</span>
                <form action="{{ route('direksi.riwayat') }}" method="GET" class="flex w-full md:w-1/3 gap-2">
                    <input type="text" name="search" placeholder="Cari vendor atau nomor kontrak"
                        value="{{ request('search') }}"
                        class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit"
                        class="px-5 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">Cari</button>
                </form>
            </div>

            {{-- Tabel --}}
            <div class="overflow-x-auto">
                <table class="w-full table-auto border-collapse mt-2">
                    <thead>
                        <tr class="text-white">
                            <th class="bg-blue-200 text-blue-600 px-4 py-3 text-left font-semibold">No</th>
                            <th class="bg-blue-200 text-blue-600 px-4 py-3 text-left font-semibold">Nama Vendor</th>
                            <th class="bg-blue-200 text-blue-600 px-4 py-3 text-left font-semibold">Nomor Kontrak</th>
                            <th class="bg-blue-200 text-blue-600 px-4 py-3 text-left font-semibold">Jenis Dokumen</th>
                            <th class="bg-blue-200 text-blue-600 px-4 py-3 text-left font-semibold">Nilai Pekerjaan (Rp)
                            </th>
                            <th class="bg-blue-200 text-blue-600 px-4 py-3 text-left font-semibold">Status</th>
                            <th class="bg-blue-200 text-blue-600 px-4 py-3 text-left font-semibold">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="text-gray-700">
                        @forelse ($dokumen as $item)
                            @php $status = $item->status ?? '-' ; @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    {{ $loop->iteration + ($dokumen->currentPage() - 1) * $dokumen->perPage() }}</td>
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
                                        Detail</a>
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
            </div>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $dokumen->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
