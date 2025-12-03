@extends('layouts.vendor')

@section('title', 'Daftar BAPP')

@section('content')
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Daftar BAPP</h1>

    <a href="{{ route('vendor.dokumenba.create', ['jenis' => 'bapp']) }}"
        class="inline-block bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-3 rounded-xl font-semibold shadow transition">
        + Buat BAPP Baru
    </a>

    <div class="overflow-x-auto mt-6 bg-white shadow-md rounded-xl border border-gray-200">
        <table class="w-full text-sm">
            <thead class="bg-sky-200 text-gray-800">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Nama Vendor</th>
                    <th class="px-4 py-3 text-left">Nomor Kontrak</th>
                    <th class="px-4 py-3 text-left">Deskripsi Pekerjaan</th>
                    <th class="px-4 py-3 text-left">Nilai Pekerjaan</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($dokumen as $item)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3">{{ $item->nama_vendor ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $item->nomor_kontrak ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $item->deskripsi_pekerjaan }}</td>
                        <td class="px-4 py-3">Rp {{ number_format($item->nilai_pekerjaan, 0, ',', '.') }}</td>

                        <td class="px-4 py-3">
                            @if ($item->status == 'pending')
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                    Pending
                                </span>
                            @elseif($item->status == 'submitted')
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-sky-100 text-sky-700">
                                    Submitted
                                </span>
                            @elseif($item->status == 'accepted')
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                    Accepted
                                </span>
                            @elseif($item->status == 'rejected')
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-700">
                                    Rejected
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-200 text-gray-700">
                                    -
                                </span>
                            @endif
                        </td>

                        <td class="px-4 py-3 flex gap-2">
                            <a href="{{ isset($item->id_ba) ? route('vendor.dokumen.pdf.preview', $item->id_ba) : '#' }}"
                                class="px-3 py-1 rounded-md bg-sky-600 hover:bg-sky-700 text-white text-xs font-semibold shadow"
                                target="_blank">
                                Preview PDF
                            </a>
                            <a href="{{ route('vendor.bapp.show', $item->id_ba) }}"
                                class="px-3 py-1 rounded-md bg-sky-600 hover:bg-sky-700 text-white text-xs font-semibold shadow">
                                Detail
                            </a>

                            <a href="{{ route('vendor.dokumenba.edit', $item->id_ba) }}"
                                class="px-3 py-1 rounded-md bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-semibold shadow">
                                Edit
                            </a>

                            <form action="{{ route('vendor.dokumenba.destroy', $item->id_ba) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-1 rounded-md bg-rose-500 hover:bg-rose-600 text-white text-xs font-semibold shadow">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-gray-500">
                            Belum ada data BAPP.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
