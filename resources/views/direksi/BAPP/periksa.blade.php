@extends('layouts.direksi')

@section('content')
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('direksi.bapp.index') }}" class="bg-white p-2 rounded-lg border hover:bg-gray-50">
            <i class="iconify w-5 h-5" data-icon="uil:arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-[#264567]">Validasi BAPP</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- KOLOM KIRI: Informasi Detail & Rincian -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Header Info -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Informasi Pekerjaan</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="block text-gray-500 text-xs">Nama Vendor</span>
                        <span class="font-semibold text-gray-800">{{ $ba->nama_vendor }}</span>
                    </div>
                    <div>
                        <span class="block text-gray-500 text-xs">Nomor Kontrak</span>
                        <span class="font-semibold text-gray-800">{{ $ba->nomor_kontrak }}</span>
                    </div>
                    <div class="col-span-2">
                        <span class="block text-gray-500 text-xs">Deskripsi Pekerjaan</span>
                        <span class="font-semibold text-gray-800">{{ $ba->deskripsi_pekerjaan }}</span>
                    </div>
                    <div>
                        <span class="block text-gray-500 text-xs">Nilai Pekerjaan</span>
                        <span class="font-bold text-[#264567] text-lg">Rp
                            {{ number_format($ba->nilai_pekerjaan, 0, ',', '.') }}</span>
                    </div>
                    <div>
                        <span class="block text-gray-500 text-xs">Tanggal Pengajuan</span>
                        <span class="font-semibold text-gray-800">{{ $ba->created_at->format('d F Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Tabel Item Pekerjaan -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Rincian Item</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border rounded-lg">
                        <thead class="bg-gray-100 text-gray-600">
                            <tr>
                                <th class="p-3">Uraian</th>
                                <th class="p-3">Vol/Spek</th>
                                <th class="p-3">Status</th>
                                <th class="p-3">Ket</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach ($ba->bapp as $item)
                                <tr>
                                    <td class="p-3">{{ $item->uraian_pekerjaan }}</td>
                                    <td class="p-3">{{ $item->spesifikasi_volume }}</td>
                                    <td class="p-3">
                                        <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-xs">
                                            {{ $item->status_pekerjaan }}
                                        </span>
                                    </td>
                                    <td class="p-3 text-gray-500">{{ $item->keterangan ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: Form Keputusan -->
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-xl shadow-lg border border-blue-100 sticky top-4">
                <div class="flex items-center gap-2 mb-4 text-[#264567]">
                    <i class="iconify w-6 h-6" data-icon="material-symbols:gavel-rounded"></i>
                    <h3 class="text-lg font-bold">Keputusan Direksi</h3>
                </div>

                <p class="text-sm text-gray-500 mb-6">
                    Silakan tinjau rincian pekerjaan di samping sebelum memberikan persetujuan.
                </p>

                <!-- FORM 1: KHUSUS UNTUK TOLAK (REJECT) -->
                <!-- Kita pisahkan form reject agar tidak bentrok dengan modal -->
                <form action="{{ route('direksi.bapp.submit_periksa', $ba->id_ba) }}" method="POST" id="form-reject">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Approval / Revisi</label>
                        <textarea name="catatan" id="catatan_main" rows="5"
                            class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm"
                            placeholder="Tuliskan catatan untuk vendor..."></textarea>
                        @error('catatan')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3 mt-6">
                        <!-- Tombol TOLAK (Langsung Submit Form Ini) -->
                        <button type="submit" name="status" value="rejected" onclick="return confirm('Tolak BAPP ini?')"
                            class="flex items-center justify-center gap-2 w-full py-3 bg-red-50 text-red-600 rounded-lg font-semibold hover:bg-red-100 transition border border-red-200">
                            <i class="iconify" data-icon="uil:times-circle"></i> Tolak
                        </button>

                        <!-- Tombol SETUJU (Memicu Modal, Bukan Submit Form Ini) -->
                        <button type="button" onclick="openModal(this)" data-modal="#modal-signature"
                            class="flex items-center justify-center gap-2 w-full py-3 bg-[#264567] text-white rounded-lg font-semibold hover:bg-[#1e3a5a] transition shadow-md">
                            <i class="iconify" data-icon="uil:pen"></i> Setuju & TTD
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

{{-- MODAL SECTION --}}
@push('modal')
    <div id="modal-signature"
        class="fixed z-50 inset-0 bg-black bg-opacity-50 hidden justify-center items-center backdrop-blur-sm">
        <div class="bg-white p-6 rounded-xl shadow-2xl w-full max-w-lg animate-scaleIn">

            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-[#264567]">Tanda Tangan Persetujuan</h2>
                <button onclick="closeModal(this)" data-modal="#modal-signature"
                    class="text-gray-500 hover:text-black text-xl">&times;</button>
            </div>

            <!-- FORM 2: KHUSUS UNTUK SETUJU (ACCEPT) DI DALAM MODAL -->
            <form action="{{ route('direksi.bapp.submit_periksa', $ba->id_ba) }}" method="POST"
                onsubmit="return submitSignature()">
                @csrf
                <input type="hidden" name="status" value="accepted">
                <input type="hidden" name="signature_image" id="signature_image">
                <!-- Input hidden untuk menampung catatan dari form utama -->
                <input type="hidden" name="catatan" id="catatan_modal">

                <p class="text-gray-600 text-sm mb-4">
                    Dengan menandatangani ini, Anda menyatakan bahwa pekerjaan telah selesai dan sesuai spesifikasi.
                </p>

                <!-- Area Canvas -->
                <div class="border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 mb-4 relative">
                    <canvas id="signature-pad" class="w-full h-48 cursor-crosshair block touch-none"></canvas>
                    <button type="button" onclick="clearSignature()"
                        class="absolute top-2 right-2 text-xs text-red-500 hover:text-red-700 bg-white px-2 py-1 rounded shadow border z-10">
                        Hapus
                    </button>
                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" onclick="closeModal(this)" data-modal="#modal-signature"
                        class="px-4 py-2 border rounded-lg hover:bg-gray-100">
                        Batal
                    </button>

                    <button type="submit"
                        class="px-4 py-2 bg-[#264567] text-white rounded-lg hover:bg-[#1a314d] flex items-center gap-2">
                        <i class="iconify" data-icon="uil:check"></i> Simpan & Setuju
                    </button>
                </div>
            </form>
        </div>
    </div>
@endpush

{{-- SCRIPTS SECTION --}}
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

    <script>
        let signaturePad;

        function openModal(element) {
            const modalId = element.getAttribute('data-modal');
            const modal = document.querySelector(modalId);

            // Copy Catatan dari Form Utama ke Form Modal (Fitur UX)
            const catatanMain = document.getElementById('catatan_main').value;
            document.getElementById('catatan_modal').value = catatanMain;

            if (modal) {
                modal.classList.remove("hidden");
                modal.classList.add("flex");

                // Init Signature Pad saat modal terbuka agar ukuran canvas benar
                const canvas = document.getElementById('signature-pad');
                if (canvas) {
                    // Resize logic for retina display support
                    const ratio = Math.max(window.devicePixelRatio || 1, 1);
                    canvas.width = canvas.offsetWidth * ratio;
                    canvas.height = canvas.offsetHeight * ratio;
                    canvas.getContext("2d").scale(ratio, ratio);

                    if (!signaturePad) {
                        signaturePad = new SignaturePad(canvas, {
                            backgroundColor: 'rgba(255, 255, 255, 0)' // Transparan
                        });
                    } else {
                        // Jika dibuka kembali, clear canvas atau biarkan (sesuai kebutuhan)
                        // signaturePad.clear(); 
                    }
                }
            }
        }

        function closeModal(element) {
            const modalId = element.getAttribute('data-modal');
            const modal = document.querySelector(modalId);

            if (modal) {
                modal.classList.remove("flex");
                modal.classList.add("hidden");
            }
        }

        function clearSignature() {
            if (signaturePad) {
                signaturePad.clear();
            }
        }

        function submitSignature() {
            if (!signaturePad || signaturePad.isEmpty()) {
                alert("Harap tanda tangan terlebih dahulu.");
                return false;
            }

            // Simpan data gambar ke input hidden
            const data = signaturePad.toDataURL('image/png');
            document.getElementById('signature_image').value = data;
            return true;
        }
    </script>
@endpush
