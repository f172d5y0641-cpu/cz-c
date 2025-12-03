<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Signature - BAPB System</title>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        #signature-pad {
            border: 2px solid #d1d5db;
            border-radius: 0.5rem;
            background-color: white;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg p-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Tanda Tangan Digital</h1>
            <p class="text-gray-600">Gunakan mouse atau touch untuk membuat tanda tangan di bawah ini</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6">
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Canvas Tanda Tangan:</label>
                <canvas id="signature-pad" width="800" height="300" class="w-full"></canvas>
            </div>

            <div class="flex flex-wrap gap-4 mb-6">
                <button type="button" id="clear" 
                    class="px-6 py-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 font-medium">
                    🗑️ Hapus Tanda Tangan
                </button>
                <button type="button" id="undo" 
                    class="px-6 py-3 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 font-medium">
                    ↩️ Undo
                </button>
                <button type="button" id="change-color" 
                    class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 font-medium">
                    🎨 Ganti Warna
                </button>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Pilih Warna:</label>
                <div class="flex gap-2">
                    <button type="button" data-color="#000000" class="w-8 h-8 bg-black rounded-full border-2 border-gray-300"></button>
                    <button type="button" data-color="#3b82f6" class="w-8 h-8 bg-blue-500 rounded-full"></button>
                    <button type="button" data-color="#ef4444" class="w-8 h-8 bg-red-500 rounded-full"></button>
                    <button type="button" data-color="#10b981" class="w-8 h-8 bg-green-500 rounded-full"></button>
                    <button type="button" data-color="#8b5cf6" class="w-8 h-8 bg-purple-500 rounded-full"></button>
                </div>
            </div>
        </div>

        <form id="signature-form" action="{{ route('pic-gudang.signature.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Nama Penandatangan:</label>
                    <input type="text" name="signer_name" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Masukkan nama lengkap">
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Jabatan:</label>
                    <input type="text" name="position" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Contoh: PIC Gudang">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Catatan (Opsional):</label>
                <textarea name="notes" rows="3" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Tambahkan catatan jika diperlukan..."></textarea>
            </div>

            <input type="hidden" name="signature_data" id="signature-data">

            <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                <a href="{{ url()->previous() }}" 
                   class="px-6 py-3 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 font-medium">
                    ← Kembali
                </a>
                
                <div class="flex gap-4">
                    <button type="button" id="preview" 
                        class="px-6 py-3 bg-purple-500 text-white rounded-lg hover:bg-purple-600 font-medium">
                        👁️ Preview
                    </button>
                    
                    <button type="submit" id="save-btn" 
                        class="px-8 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium text-lg">
                        💾 Simpan Tanda Tangan
                    </button>
                </div>
            </div>
        </form>

        <!-- Preview Modal -->
        <div id="preview-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center p-4 z-50">
            <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold text-gray-800">Preview Tanda Tangan</h3>
                        <button id="close-preview" class="text-gray-500 hover:text-gray-700 text-2xl">×</button>
                    </div>
                    
                    <div class="border-2 border-dashed border-gray-300 p-4 rounded-lg mb-6">
                        <div id="signature-preview" class="bg-white p-4"></div>
                    </div>
                    
                    <div class="text-center">
                        <p class="text-gray-600 mb-2">Pastikan tanda tangan sudah benar sebelum disimpan</p>
                        <button id="confirm-save" class="px-8 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium">
                            ✅ Ya, Simpan Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize Signature Pad
        const canvas = document.getElementById('signature-pad');
        const signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgb(255, 255, 255)',
            penColor: 'rgb(0, 0, 0)'
        });

        // Clear button
        document.getElementById('clear').addEventListener('click', () => {
            signaturePad.clear();
        });

        // Undo button
        document.getElementById('undo').addEventListener('click', () => {
            const data = signaturePad.toData();
            if (data) {
                data.pop(); // remove the last dot or line
                signaturePad.fromData(data);
            }
        });

        // Color buttons
        document.querySelectorAll('[data-color]').forEach(button => {
            button.addEventListener('click', (e) => {
                const color = e.target.getAttribute('data-color');
                signaturePad.penColor = color;
            });
        });

        // Change color button
        document.getElementById('change-color').addEventListener('click', () => {
            const colors = ['#000000', '#3b82f6', '#ef4444', '#10b981', '#8b5cf6'];
            const randomColor = colors[Math.floor(Math.random() * colors.length)];
            signaturePad.penColor = randomColor;
        });

        // Preview button
        document.getElementById('preview').addEventListener('click', () => {
            if (signaturePad.isEmpty()) {
                alert('Silahkan buat tanda tangan terlebih dahulu!');
                return;
            }

            const signatureData = signaturePad.toDataURL();
            document.getElementById('signature-preview').innerHTML = 
                `<img src="${signatureData}" alt="Signature Preview" class="max-w-full h-auto mx-auto">`;
            
            document.getElementById('preview-modal').classList.remove('hidden');
            document.getElementById('preview-modal').classList.add('flex');
        });

        // Close preview modal
        document.getElementById('close-preview').addEventListener('click', () => {
            document.getElementById('preview-modal').classList.add('hidden');
            document.getElementById('preview-modal').classList.remove('flex');
        });

        // Confirm save from preview
        document.getElementById('confirm-save').addEventListener('click', () => {
            document.getElementById('signature-form').submit();
        });

        // Form submission
        document.getElementById('signature-form').addEventListener('submit', function(e) {
            if (signaturePad.isEmpty()) {
                e.preventDefault();
                alert('Silahkan buat tanda tangan terlebih dahulu!');
                return;
            }

            // Convert signature to data URL and set to hidden input
            const signatureData = signaturePad.toDataURL();
            document.getElementById('signature-data').value = signatureData;
            
            // Optional: Show loading
            document.getElementById('save-btn').innerHTML = 'Menyimpan...';
            document.getElementById('save-btn').disabled = true;
        });

        // Adjust canvas on resize
        function resizeCanvas() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
            signaturePad.clear(); // otherwise isEmpty() might return incorrect value
        }

        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();
    </script>
</body>
</html>