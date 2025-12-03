@extends('layouts.direksi')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('direksi.bapp.index') }}" class="flex items-center gap-2 text-gray-600 hover:text-[#264567]">
                <i class="iconify" data-icon="uil:arrow-left"></i> Kembali
            </a>

            <!-- Status Badge Besar -->
            @if ($ba->status == 'accepted' || $ba->status == 'approved')
                <div class="px-4 py-2 bg-green-100 text-green-800 rounded-lg flex items-center gap-2 font-bold">
                    <i class="iconify" data-icon="uil:check-circle"></i> DISETUJUI
                </div>
            @elseif($ba->status == 'rejected')
                <div class="px-4 py-2 bg-red-100 text-red-800 rounded-lg flex items-center gap-2 font-bold">
                    <i class="iconify" data-icon="uil:times-circle"></i> DITOLAK
                </div>
            @else
                <div class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-lg flex items-center gap-2 font-bold">
                    <i class="iconify" data-icon="uil:clock"></i> {{ strtoupper($ba->status) }}
                </div>
            @endif
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <!-- Header Print Style -->
            <div class="bg-[#264567] text-white p-8">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-bold">Detail BAPP</h2>
                        <p class="opacity-80 mt-1">{{ $ba->nomor_kontrak }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm opacity-70">Vendor</p>
                        <p class="font-semibold text-lg">{{ $ba->nama_vendor }}</p>
                        <p class="text-sm opacity-70">{{ $ba->perusahaan }}</p>
                    </div>
                </div>
            </div>

            <div class="p-8">
                <!-- Informasi Utama -->
                <div class="grid grid-cols-2 gap-8 mb-8">
                    <div>
                        <h4 class="text-gray-500 text-sm uppercase font-bold mb-2">Deskripsi Pekerjaan</h4>
                        <p class="text-gray-800 leading-relaxed">{{ $ba->deskripsi_pekerjaan }}</p>
                    </div>
                    <div>
                        <h4 class="text-gray-500 text-sm uppercase font-bold mb-2">Nilai Pekerjaan</h4>
                        <p class="text-2xl font-bold text-[#264567]">Rp
                            {{ number_format($ba->nilai_pekerjaan, 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- Tabel Detail Item -->
                <h4 class="text-gray-500 text-sm uppercase font-bold mb-4">Rincian Item Pekerjaan</h4>
                <table class="w-full text-sm text-left border rounded-lg mb-8">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="p-3 border-b">Uraian</th>
                            <th class="p-3 border-b">Spesifikasi</th>
                            <th class="p-3 border-b">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ba->bapp as $item)
                            <tr class="border-b last:border-0">
                                <td class="p-3">{{ $item->uraian_pekerjaan }}</td>
                                <td class="p-3">{{ $item->spesifikasi_volume }}</td>
                                <td class="p-3 font-semibold">{{ $item->status_pekerjaan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Riwayat Approval -->
                @if ($ba->approval)
                    <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                        <h4 class="text-[#264567] font-bold mb-4 flex items-center gap-2">
                            <i class="iconify" data-icon="uil:clipboard-notes"></i> Catatan Pemeriksaan
                        </h4>

                        <div class="grid grid-cols-[100px_1fr] gap-4 text-sm">
                            <span class="text-gray-500">Pemeriksa</span>
                            <span class="font-semibold">{{ $ba->approval->user->name ?? 'Direksi' }}</span>

                            <span class="text-gray-500">Tanggal</span>
                            <span>{{ \Carbon\Carbon::parse($ba->approval->tanggal_approval)->translatedFormat('d F Y, H:i') }}
                                WIB</span>

                            <span class="text-gray-500">Catatan</span>
                            <div class="bg-white p-3 rounded border text-gray-700 italic">
                                "{{ $ba->approval->catatan ?? 'Tidak ada catatan.' }}"
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
