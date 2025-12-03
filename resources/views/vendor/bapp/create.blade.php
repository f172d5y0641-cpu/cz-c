@extends('layouts.vendor')

@section('title', 'Buat BAPP Baru')

@section('content')
    <h1 class="text-center text-xl font-bold mb-6 text-gray-800">Buat BAPP Baru</h1>

    <div class="bg-white p-8 rounded-2xl shadow-md border border-gray-200 max-w-5xl mx-auto">

        <form action="{{ route('vendor.dokumenba.store') }}" method="POST" id="bapp-form">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="flex flex-col">
                    <label for="nama_vendor" class="font-semibold text-gray-700 mb-1">Nama Vendor</label>
                    <input type="text" name="nama_vendor" id="nama_vendor"
                        class="p-3 rounded-lg border border-gray-300 bg-white focus:ring-2 focus:ring-sky-300" required>
                </div>

                <div class="flex flex-col">
                    <label for="jabatan" class="font-semibold text-gray-700 mb-1">Jabatan</label>
                    <input type="text" name="jabatan" id="jabatan"
                        class="p-3 rounded-lg border border-gray-300 bg-white focus:ring-2 focus:ring-sky-300" required>
                </div>

                <div class="flex flex-col">
                    <label for="perusahaan" class="font-semibold text-gray-700 mb-1">Perusahaan</label>
                    <input type="text" name="perusahaan" id="perusahaan"
                        class="p-3 rounded-lg border border-gray-300 bg-white focus:ring-2 focus:ring-sky-300" required>
                </div>

                <div class="flex flex-col">
                    <label for="alamat" class="font-semibold text-gray-700 mb-1">Alamat</label>
                    <input type="text" name="alamat" id="alamat"
                        class="p-3 rounded-lg border border-gray-300 bg-white focus:ring-2 focus:ring-sky-300" required>
                </div>

                <div class="flex flex-col">
                    <label for="nomor_kontrak" class="font-semibold text-gray-700 mb-1">Nomor Kontrak</label>
                    <input type="text" name="nomor_kontrak" id="nomor_kontrak"
                        class="p-3 rounded-lg border border-gray-300 bg-white focus:ring-2 focus:ring-sky-300" required>
                </div>

                <div class="flex flex-col">
                    <label for="jenis_dokumen" class="font-semibold text-gray-700 mb-1">Jenis Dokumen</label>
                    <select name="jenis_dokumen" id="jenis_dokumen"
                        class="p-3 rounded-lg border border-gray-300 bg-white focus:ring-2 focus:ring-sky-300" required>
                        <option value="BAPB">BAPB</option>
                        <option value="BAPP" selected>BAPP</option>
                    </select>
                </div>

                <div class="flex flex-col md:col-span-2">
                    <label for="deskripsi_pekerjaan" class="font-semibold text-gray-700 mb-1">Deskripsi Pekerjaan</label>
                    <textarea name="deskripsi_pekerjaan" id="deskripsi_pekerjaan" rows="3"
                        class="p-3 rounded-lg border border-gray-300 bg-white focus:ring-2 focus:ring-sky-300" required></textarea>
                </div>

                <div class="flex flex-col">
                    <label for="nilai_pekerjaan" class="font-semibold text-gray-700 mb-1">Nilai Pekerjaan (Rp)</label>
                    <input type="number" name="nilai_pekerjaan" id="nilai_pekerjaan" step="0.01"
                        class="p-3 rounded-lg border border-gray-300 bg-white focus:ring-2 focus:ring-sky-300" required>
                </div>
            </div>

            <hr class="my-8 border-gray-300">

            <h3 class="text-lg font-semibold text-gray-800 mb-3">Daftar Pekerjaan</h3>

            <table class="w-full border border-gray-300 rounded-xl overflow-hidden">
                <thead>
                    <tr class="bg-sky-200 text-gray-800">
                        <th class="p-3 border font-semibold">Uraian Pekerjaan</th>
                        <th class="p-3 border font-semibold">Spesifikasi / Volume</th>
                        <th class="p-3 border font-semibold">Status Pekerjaan</th>
                        <th class="p-3 border font-semibold">Keterangan</th>
                        <th class="p-3 border font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody id="pekerjaan-table">
                    <tr class="bg-white hover:bg-gray-50 transition">
                        <td class="p-2 border">
                            <input type="text" name="pekerjaan[0][uraian]"
                                class="w-full p-2 rounded-md border border-gray-300 bg-white" required>
                        </td>
                        <td class="p-2 border">
                            <input type="text" name="pekerjaan[0][spesifikasi]"
                                class="w-full p-2 rounded-md border border-gray-300 bg-white" required>
                        </td>
                        <td class="p-2 border">
                            <select name="pekerjaan[0][status]"
                                class="w-full p-2 rounded-md border border-gray-300 bg-white" required>
                                <option value="Selesai">Selesai</option>
                                <option value="Belum Selesai">Belum Selesai</option>
                            </select>
                        </td>
                        <td class="p-2 border">
                            <input type="text" name="pekerjaan[0][keterangan]"
                                class="w-full p-2 rounded-md border border-gray-300 bg-white">
                        </td>
                        <td class="p-2 border text-center">
                            <button type="button"
                                class="bg-rose-500 hover:bg-rose-600 text-white px-3 py-1 rounded-md text-sm"
                                onclick="hapusRow(this)">Hapus</button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-4">
                <button type="button"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-semibold"
                    onclick="tambahRow()">+ Tambah Pekerjaan</button>
            </div>

            <div class="flex gap-4 mt-8">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-semibold">Simpan</button>
                <button type="button" class="bg-rose-400 hover:bg-rose-500 text-white px-6 py-3 rounded-xl font-semibold"
                    onclick="resetForm()">Hapus</button>
            </div>
        </form>
    </div>

    <script>
        let index = 1;

        document.getElementById('bapp-form').addEventListener('submit', function(e) {
            const yakin = confirm("Apakah Anda yakin ingin menyimpan data ini?");
            if (!yakin) {
                e.preventDefault(); 
            }
        });

        function tambahRow() {
            const tbody = document.getElementById('pekerjaan-table');

            const newRow = `
        <tr class="bg-white hover:bg-gray-50 transition">
            <td class="p-2 border"><input type="text" name="pekerjaan[${index}][uraian]" class="w-full p-2 rounded-md border border-gray-300 bg-white" required></td>
            <td class="p-2 border"><input type="text" name="pekerjaan[${index}][spesifikasi]" class="w-full p-2 rounded-md border border-gray-300 bg-white" required></td>
            <td class="p-2 border">
                <select name="pekerjaan[${index}][status]" class="w-full p-2 rounded-md border border-gray-300 bg-white" required>
                    <option value="Selesai">Selesai</option>
                    <option value="Belum Selesai">Belum Selesai</option>
                </select>
            </td>
            <td class="p-2 border"><input type="text" name="pekerjaan[${index}][keterangan]" class="w-full p-2 rounded-md border border-gray-300 bg-white"></td>
            <td class="p-2 border text-center">
                <button type="button" class="bg-rose-500 hover:bg-rose-600 text-white px-3 py-1 rounded-md text-sm" onclick="hapusRow(this)">Hapus</button>
            </td>
        </tr>
    `;

            tbody.insertAdjacentHTML('beforeend', newRow);
            index++;
        }

        function hapusRow(btn) {
            if (confirm("Apakah Anda yakin ingin menghapus baris ini?")) {
                btn.closest('tr').remove();
            }
        }

        function resetForm() {
            if (!confirm("Apakah Anda yakin ingin menghapus seluruh data dan mengosongkan form?")) return;

            document.getElementById('bapp-form').reset();
            document.getElementById('pekerjaan-table').innerHTML = '';
            index = 0;
            tambahRow();
        }
    </script>

@endsection
