@extends('layouts.direksi')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-[#264567]">Daftar Pemeriksaan BAPP</h1>
            <p class="text-gray-500 mt-1">Kelola dan validasi Berita Acara Pemeriksaan Pekerjaan.</p>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 text-gray-600 text-sm uppercase tracking-wider">
                    <tr>
                        <th class="p-4 font-semibold border-b">No</th>
                        <th class="p-4 font-semibold border-b">Vendor & Proyek</th>
                        <th class="p-4 font-semibold border-b">Tanggal Masuk</th>
                        <th class="p-4 font-semibold border-b">Nilai Kontrak</th>
                        <th class="p-4 font-semibold border-b text-center">Status</th>
                        <th class="p-4 font-semibold border-b text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    @forelse($bappList as $ba)
                        <tr class="hover:bg-gray-50 transition border-b last:border-b-0">
                            <td class="p-4 text-center">{{ $loop->iteration }}</td>
                            <td class="p-4">
                                <p class="font-bold text-[#264567]">{{ $ba->nama_vendor }}</p>
                                <p class="text-xs text-gray-500">{{ Str::limit($ba->deskripsi_pekerjaan, 40) }}</p>
                                <p class="text-xs text-gray-400 mt-1">No: {{ $ba->nomor_kontrak }}</p>
                            </td>
                            <td class="p-4">{{ $ba->created_at->format('d M Y') }}</td>
                            <td class="p-4 font-medium">Rp {{ number_format($ba->nilai_pekerjaan, 0, ',', '.') }}</td>
                            <td class="p-4 text-center">
                                @if ($ba->status == 'submitted' || $ba->status == 'pending')
                                    <span
                                        class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        Perlu Diperiksa
                                    </span>
                                @elseif($ba->status == 'accepted' || $ba->status == 'approved')
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        Disetujui
                                    </span>
                                @elseif($ba->status == 'rejected')
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        Ditolak
                                    </span>
                                @else
                                    <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-semibold">
                                        {{ $ba->status }}
                                    </span>
                                @endif
                            </td>
                            <td class="p-4">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('direksi.bapp.detail', $ba->id_ba) }}"
                                        class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition"
                                        title="Lihat Detail">
                                        <i class="iconify w-5 h-5" data-icon="uil:eye"></i>
                                    </a>

                                    {{-- Tombol Periksa hanya muncul jika status submitted/pending --}}
                                    @if ($ba->status == 'submitted' || $ba->status == 'pending')
                                        <a href="{{ route('direksi.bapp.periksa', $ba->id_ba) }}"
                                            class="p-2 bg-[#264567] text-white rounded-lg hover:bg-[#1a314d] transition shadow-md"
                                            title="Periksa & Validasi">
                                            <i class="iconify w-5 h-5" data-icon="uil:check-circle"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-400">
                                <i class="iconify w-12 h-12 mx-auto mb-2 opacity-50" data-icon="uil:folder-slash"></i>
                                <p>Belum ada data BAPP masuk.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
