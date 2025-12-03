@extends('layouts.vendor')

@section('title', 'Detail BAPB')

@section('content')

    <h1 class="text-3xl font-bold text-blue-900 mb-6 tracking-wide">Detail BAPB</h1>

    <a href="{{ route('vendor.bapb.index') }}"
        class="inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded-lg mb-6 shadow hover:bg-blue-700 transition">
        ← Kembali
    </a>

    <div class="bg-white shadow-lg rounded-xl p-6 mb-8 border border-gray-200">
        <h2 class="text-xl font-semibold text-blue-700 mb-4">Informasi Dokumen</h2>

        <table class="w-full border-collapse">
            <tbody class="text-gray-800">
                <tr class="border-b">
                    <th class="p-3 bg-blue-50 font-medium w-1/4 rounded-l-lg">Nama Vendor</th>
                    <td class="p-3">{{ $dokumen->nama_vendor }}</td>
                </tr>

                <tr class="border-b">
                    <th class="p-3 bg-blue-50 font-medium">Jabatan</th>
                    <td class="p-3">{{ $dokumen->jabatan }}</td>
                </tr>

                <tr class="border-b">
                    <th class="p-3 bg-blue-50 font-medium">Perusahaan</th>
                    <td class="p-3">{{ $dokumen->perusahaan }}</td>
                </tr>

                <tr class="border-b">
                    <th class="p-3 bg-blue-50 font-medium">Alamat</th>
                    <td class="p-3">{{ $dokumen->alamat }}</td>
                </tr>

                <tr class="border-b">
                    <th class="p-3 bg-blue-50 font-medium">Nomor Kontrak</th>
                    <td class="p-3">{{ $dokumen->nomor_kontrak }}</td>
                </tr>

                <tr class="border-b">
                    <th class="p-3 bg-blue-50 font-medium">Nilai Barang</th>
                    <td class="p-3">Rp {{ number_format($dokumen->nilai_pekerjaan, 0, ',', '.') }}</td>
                </tr>

                <tr class="border-b">
                    <th class="p-3 bg-blue-50 font-medium">Status</th>
                    <td class="p-3">

                        @if ($dokumen->status == 'pending')
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
                                Pending
                            </span>
                        @elseif($dokumen->status == 'submitted')
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                Submitted
                            </span>
                        @elseif($dokumen->status == 'approved')
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                Approved
                            </span>
                        @elseif($dokumen->status == 'rejected')
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-rose-100 text-rose-700">
                                Rejected
                            </span>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th class="p-3 bg-blue-50 font-medium rounded-bl-lg">Deskripsi</th>
                    <td class="p-3">{{ $dokumen->deskripsi_pekerjaan }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-200">
        <h2 class="text-xl font-semibold text-blue-700 mb-4">Daftar Barang</h2>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-blue-600 text-white text-sm">
                        <th class="p-3 text-left">Nama Barang</th>
                        <th class="p-3 text-left">Merk/Type</th>
                        <th class="p-3 text-center">Jumlah</th>
                        <th class="p-3 text-center">Kondisi</th>
                        <th class="p-3 text-left">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800">
                    @foreach ($dokumen->bapb as $b)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3">{{ $b->nama_barang }}</td>
                            <td class="p-3">{{ $b->merk_type }}</td>
                            <td class="p-3 text-center">{{ $b->jumlah }}</td>
                            <td class="p-3 text-center">{{ $b->kondisi }}</td>
                            <td class="p-3">{{ $b->keterangan ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8 flex justify-between">
        <div class="flex gap-4">
            <a href="{{ isset($item->id_ba) ? route('vendor.dokumen.pdf.preview', $item->id_ba) : '#' }}"
                class=" bg-sky-600 text-white px-5 py-2 rounded-lg shadow hover:bg-sky-700 transition" target="_blank">
                Preview PDF
            </a>

            <a href="{{ route('vendor.dokumenba.edit', $dokumen->id_ba) }}"
                class="bg-yellow-500 text-white px-5 py-2 rounded-lg shadow hover:bg-yellow-600 transition">
                Edit
            </a>
            <form action="{{ route('vendor.dokumenba.destroy', $dokumen->id_ba) }}" method="POST"
                onsubmit="return confirm('Yakin ingin menghapus?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="bg-red-500 text-white px-5 py-2 rounded-lg shadow hover:bg-red-600 transition">
                    Hapus
                </button>
            </form>
        </div>
        <div class="flex gap-4">
            <a href="#" onclick="openModal(this)" data-modal="#tanda-tangan-modal" data-pdf="{{ $pdfRenderUrl ?? $pdfUrl ?? '' }}"
                class="bg-sky-500 text-white px-5 py-2 rounded-lg shadow hover:bg-sky-600 transition flex gap-2 items-center">
                <i class="iconify w-6 h-6" data-icon="mdi:sign"></i>
                Tanda Tangan
            </a>
            <a href="{{route('vendor.dokumen.pdf.kirim', $dokumen)}}" onclick="return confirm('Kirim?')"
                class="bg-blue-500 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-600 transition flex gap-2 items-center">
                <i class="iconify w-6 h-6" data-icon="prime:send"></i>
                Kirim
            </a>
        </div>
    </div>

@endsection
@push('modal')
    <div id="tanda-tangan-modal" data-modal="#tanda-tangan-modal" onclick="backdropClose(event)"
        class="fixed z-10 inset-0 bg-black/10 bg-opacity-50 hidden justify-center items-center">
        <div class="bg-white p-6 rounded-xl shadow-lg w-11/12 max-h-[90vh] overflow-auto animate-scaleIn"
            onclick="event.stopPropagation()">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Modal Title</h2>
                <button onclick="closeModal(this)" data-modal="#tanda-tangan-modal"
                    class="text-gray-500 hover:text-black text-xl">&times;</button>
            </div>

            <form class="grid grid-cols-[3fr_1fr]" method="POST"
                action="{{ route('vendor.dokumen.pdf.sign', $dokumen->id_ba) }}" onsubmit="handleSubmit(event)">
                @csrf
                <div class="w-full border border-gray-200 rounded-md bg-white shadow-inner p-2 relative">
                    <div class="draggable hidden absolute top-2 left-2 w-40 h-20 border-2 border-dashed border-sky-400 rounded bg-white/80 backdrop-blur-sm shadow text-sky-700 text-[11px] font-semibold flex items-center justify-center select-none"
                        data-x="0" data-y="0">
                        Tarik tanda tangan
                    </div>
                    <canvas id="pdf-canvas" class="w-full"></canvas>

                    <!-- some props that needed -->
                    <input type="hidden" id="stampX" name="stampX">
                    <input type="hidden" id="stampY" name="stampY">
                    <input type="hidden" id="canvasHeight" name="canvasHeight">
                    <input type="hidden" id="canvasWidth" name="canvasWidth">
                    <input type="hidden" id="signature_image" name="signature_image">
                    <input type="hidden" id="stampWidth" name="stampWidth">
                    <input type="hidden" id="stampHeight" name="stampHeight">
                </div>

                <div class="w-full">
                    <canvas class="border border-black w-full h-48" id="signature-pad"></canvas>
                    <div class="flex gap-2 mt-4">
                        <a href="#"
                            class="bg-gray-300 text-gray-500 px-5 py-2 rounded-lg shadow hover:bg-gray-600 transition flex gap-2 items-center"
                            onclick="canvasAction('clear')">

                            <i class="iconify w-6 h-6" data-icon="ci:undo"></i>
                        </a>
                        <a href="#"
                            class="bg-blue-300 text-blue-500 px-5 py-2 rounded-lg shadow hover:bg-blue-600 hover:text-blue-300 transition flex gap-2 items-center"
                            onclick="canvasToImage()">
                            <i class="iconify w-6 h-6" data-icon="material-symbols:save-outline-rounded"></i>
                        </a>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-2 col-span-2">
                    <button type="button" onclick="closeModal(this)" data-modal="#tanda-tangan-modal"
                        class="px-4 py-2 border rounded-lg hover:bg-gray-100">
                        Cancel
                    </button>

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
@endpush

@push('scripts')
    <script>
        const pdfPreviewUrl = "{{ $pdfRenderUrl ?? $pdfUrl ?? '' }}";
        const pdfCdnBase = "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/4.0.269";
        let loadedPdfUrl = null;
        let draggableInitialized = false;

        let signaturePad;
        let signaturePadInitialized = false;

        if (typeof pdfjsLib !== "undefined" && pdfjsLib.GlobalWorkerOptions) {
            pdfjsLib.GlobalWorkerOptions.workerSrc = `${pdfCdnBase}/pdf.worker.min.mjs`;
            pdfjsLib.GlobalWorkerOptions.cMapUrl = `${pdfCdnBase}/cmaps/`;
            pdfjsLib.GlobalWorkerOptions.cMapPacked = true;
            pdfjsLib.GlobalWorkerOptions.standardFontDataUrl = `${pdfCdnBase}/standard_fonts/`;
            pdfjsLib.GlobalWorkerOptions.useSystemFonts = true;
        }

        async function renderPdfToCanvas(url) {
            if (!url || loadedPdfUrl === url) return;
            const canvas = document.querySelector("#pdf-canvas");
            if (!canvas || typeof pdfjsLib === "undefined") return;

            try {
                const loadingTask = pdfjsLib.getDocument({
                    url,
                    withCredentials: true,
                    useSystemFonts: true,
                    disableFontFace: false,
                    cMapUrl: `${pdfCdnBase}/cmaps/`,
                    cMapPacked: true,
                    standardFontDataUrl: `${pdfCdnBase}/standard_fonts/`,
                });
                const pdf = await loadingTask.promise;

                const page = await pdf.getPage(1);
                const viewport = page.getViewport({ scale: 1 });
                const context = canvas.getContext("2d");

                canvas.width = viewport.width;
                canvas.height = viewport.height;
                canvas.style.width = `${viewport.width}px`;
                canvas.style.height = `${viewport.height}px`;

                await page.render({ canvasContext: context, viewport }).promise;
                loadedPdfUrl = url;

                const heightInput = document.querySelector("#canvasHeight");
                const widthInput = document.querySelector("#canvasWidth");
                if (heightInput) heightInput.value = Math.round(viewport.height);
                if (widthInput) widthInput.value = Math.round(viewport.width);

                canvas.classList.remove("border-2");
            } catch (error) {
                console.error("Gagal memuat PDF untuk preview", error);
            }
        }

        function resizeSignatureCanvas() {
            const canvas = document.querySelector("#signature-pad");
            if (!canvas) return;

            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            const data = signaturePad ? signaturePad.toData() : null;

            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;

            const ctx = canvas.getContext("2d");
            ctx.setTransform(1, 0, 0, 1, 0, 0);
            ctx.scale(ratio, ratio);

            if (data && signaturePad) {
                signaturePad.fromData(data);
            }
        }

        function initSignaturePad() {
            const canvas = document.querySelector("#signature-pad");
            if (!canvas) return;

            resizeSignatureCanvas();

            signaturePad = new SignaturePad(canvas, {
                minWidth: 1,
                maxWidth: 3,
                backgroundColor: "rgba(255, 255, 255, 0)"
            });

            window.addEventListener("resize", function() {
                resizeSignatureCanvas();
            });

            signaturePadInitialized = true;
        }

        function canvasToImage() {
            if (!signaturePad || signaturePad.isEmpty()) {
                alert("Tanda tangan belum diisi.");
                return null;
            }

            const dataUrl = signaturePad.toDataURL("image/png");
            const draggable = document.querySelector(".draggable");
            const signatureInput = document.querySelector("#signature_image");
            const widthInput = document.querySelector("#stampWidth");
            const heightInput = document.querySelector("#stampHeight");

            if (draggable) {
                draggable.innerHTML = `<img src="${dataUrl}" class="max-w-full max-h-full object-contain pointer-events-none" />`;
                draggable.classList.remove("hidden");
                draggable.setAttribute("data-x", 0);
                draggable.setAttribute("data-y", 0);
                draggable.style.transform = "translate(0px, 0px)";
                syncStampPosition(0, 0);
                setupDraggable();

                if (widthInput) widthInput.value = draggable.offsetWidth;
                if (heightInput) heightInput.value = draggable.offsetHeight;
            }

            if (signatureInput) {
                signatureInput.value = dataUrl;
            }

            return dataUrl;
        }

        function canvasAction(action) {
            if (!signaturePad) return;

            switch (action) {
                case "clear":
                    signaturePad.clear();
                    break;
                case "on":
                    signaturePad.on();
                    break;
                case "off":
                    signaturePad.off();
                    break;
                default:
                    break;
            }
        }

        function openModal(element) {
            const modalId = element.getAttribute("data-modal");
            const modal = document.querySelector(modalId);
            const modalPdf = element.getAttribute("data-pdf") || pdfPreviewUrl;

            if (!modal) return;

            modal.classList.remove("hidden");
            modal.classList.add("flex");

            requestAnimationFrame(function() {
                loadedPdfUrl = null;
                renderPdfToCanvas(modalPdf);

                if (!signaturePadInitialized) {
                    initSignaturePad();
                } else {
                    resizeSignatureCanvas();
                }

                setupDraggable();
            });
        }

        function closeModal(element) {
            const modalId = element.getAttribute("data-modal");
            const modal = document.querySelector(modalId);

            if (!modal) return;

            modal.classList.remove("flex");
            modal.classList.add("hidden");
        }

        function backdropClose(event) {
            if (event.target.id === "tanda-tangan-modal") {
                closeModal(event.currentTarget);
            }
        }

        function syncStampPosition(x, y) {
            const xInput = document.querySelector("#stampX");
            const yInput = document.querySelector("#stampY");
            if (xInput) xInput.value = Math.round(x);
            if (yInput) yInput.value = Math.round(y);
        }

        function setupDraggable() {
            if (draggableInitialized || typeof interact === "undefined") return;

            const dragTarget = document.querySelector(".draggable");
            if (!dragTarget) return;
            const widthInput = document.querySelector("#stampWidth");
            const heightInput = document.querySelector("#stampHeight");

            interact(dragTarget).draggable({
                inertia: true,
                modifiers: [
                    interact.modifiers.restrictRect({
                        restriction: dragTarget.parentElement,
                        endOnly: true
                    })
                ],
                listeners: {
                    move(event) {
                        const target = event.target;
                        const x = (parseFloat(target.getAttribute("data-x")) || 0) + event.dx;
                        const y = (parseFloat(target.getAttribute("data-y")) || 0) + event.dy;

                        target.style.transform = `translate(${x}px, ${y}px)`;
                        target.setAttribute("data-x", x);
                        target.setAttribute("data-y", y);

                        syncStampPosition(x, y);
                    }
                }
            });

            if (widthInput) widthInput.value = dragTarget.offsetWidth;
            if (heightInput) heightInput.value = dragTarget.offsetHeight;

            draggableInitialized = true;
        }

        function handleSubmit(event) {
            if (!signaturePad || signaturePad.isEmpty()) {
                event.preventDefault();
                alert("Silakan isi tanda tangan terlebih dahulu.");
                return false;
            }

            if (!document.querySelector("#signature_image")?.value) {
                canvasToImage();
            }

            const canvas = document.querySelector("#pdf-canvas");
            const draggable = document.querySelector(".draggable");
            const widthInput = document.querySelector("#stampWidth");
            const heightInput = document.querySelector("#stampHeight");

            if (canvas && draggable) {
                const canvasRect = canvas.getBoundingClientRect();
                const dragRect = draggable.getBoundingClientRect();

                const offsetX = Math.max(0, dragRect.left - canvasRect.left);
                const offsetY = Math.max(0, dragRect.top - canvasRect.top);
                const width = dragRect.width;
                const height = dragRect.height;

                syncStampPosition(offsetX, offsetY);
                if (widthInput) widthInput.value = width;
                if (heightInput) heightInput.value = height;
            }

            return true;
        }
    </script>
@endpush
