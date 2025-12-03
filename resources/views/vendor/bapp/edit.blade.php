@extends('layouts.vendor')

@section('title', 'Edit BAPP')

@section('content')
    <h1 class="text-2xl font-semibold mb-6 text-gray-800">Edit BAPP</h1>

    <div class="bg-white p-6 rounded-lg shadow-md border">
        <form action="{{ route('vendor.dokumenba.update', $dokumen->id_ba) }}" method="POST" id="bapp-form">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label for="nama_vendor" class="block mb-1 font-medium text-gray-700">Nama Vendor</label>
                    <input type="text" name="nama_vendor" id="nama_vendor" value="{{ $dokumen->nama_vendor }}" required
                        class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-300">
                </div>

                <div>
                    <label for="jabatan" class="block mb-1 font-medium text-gray-700">Jabatan</label>
                    <input type="text" name="jabatan" id="jabatan" value="{{ $dokumen->jabatan }}" required
                        class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-300">
                </div>

                <div>
                    <label for="perusahaan" class="block mb-1 font-medium text-gray-700">Perusahaan</label>
                    <input type="text" name="perusahaan" id="perusahaan" value="{{ $dokumen->perusahaan }}" required
                        class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-300">
                </div>

                <div>
                    <label for="alamat" class="block mb-1 font-medium text-gray-700">Alamat</label>
                    <input type="text" name="alamat" id="alamat" value="{{ $dokumen->alamat }}" required
                        class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-300">
                </div>

                <div>
                    <label for="nomor_kontrak" class="block mb-1 font-medium text-gray-700">Nomor Kontrak</label>
                    <input type="text" name="nomor_kontrak" id="nomor_kontrak" value="{{ $dokumen->nomor_kontrak }}"
                        required class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-300">
                </div>

                <div>
                    <label for="jenis_dokumen" class="block mb-1 font-medium text-gray-700">Jenis Dokumen</label>
                    <select name="jenis_dokumen" id="jenis_dokumen" required
                        class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-300">
                        <option value="BAPB">BAPB</option>
                        <option value="BAPP" selected>BAPP</option>
                    </select>
                </div>

                <div>
                    <label for="nilai_pekerjaan" class="block mb-1 font-medium text-gray-700">Nilai Pekerjaan (Rp)</label>
                    <input type="number" name="nilai_pekerjaan" id="nilai_pekerjaan"
                        value="{{ $dokumen->nilai_pekerjaan }}" required
                        class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-300">
                </div>

                <div class="md:col-span-2">
                    <label for="deskripsi_pekerjaan" class="block mb-1 font-medium text-gray-700">Deskripsi
                        Pekerjaan</label>
                    <textarea name="deskripsi_pekerjaan" id="deskripsi_pekerjaan" rows="3" required
                        class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-300">{{ $dokumen->deskripsi_pekerjaan }}</textarea>
                </div>

            </div>

            <hr class="my-6 border-gray-300">

            <h3 class="text-lg font-semibold mb-3 text-gray-800">Daftar Pekerjaan</h3>

            <table class="w-full border-collapse bg-white shadow rounded-md overflow-hidden" id="pekerjaan-table">
                <thead>
                    <tr class="bg-blue-100 text-gray-800">
                        <th class="px-3 py-2 text-left">Uraian Pekerjaan</th>
                        <th class="px-3 py-2 text-left">Spesifikasi / Volume</th>
                        <th class="px-3 py-2 text-left">Status Pekerjaan</th>
                        <th class="px-3 py-2 text-left">Keterangan</th>
                        <th class="px-3 py-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $index = 0; @endphp
                    @foreach ($dokumen->bapp as $row)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-3 py-2">
                                <input type="text" name="pekerjaan[{{ $index }}][uraian]"
                                    value="{{ $row->uraian_pekerjaan }}" required
                                    class="w-full px-2 py-1 border rounded-md">
                            </td>
                            <td class="px-3 py-2">
                                <input type="text" name="pekerjaan[{{ $index }}][spesifikasi]"
                                    value="{{ $row->spesifikasi_volume }}" required
                                    class="w-full px-2 py-1 border rounded-md">
                            </td>
                            <td class="px-3 py-2">
                                <select name="pekerjaan[{{ $index }}][status]" required
                                    class="w-full px-2 py-1 border rounded-md">
                                    <option value="Selesai" {{ $row->status_pekerjaan == 'Selesai' ? 'selected' : '' }}>
                                        Selesai</option>
                                    <option value="Belum Selesai"
                                        {{ $row->status_pekerjaan == 'Belum Selesai' ? 'selected' : '' }}>Belum Selesai
                                    </option>
                                </select>
                            </td>
                            <td class="px-3 py-2">
                                <input type="text" name="pekerjaan[{{ $index }}][keterangan]"
                                    value="{{ $row->keterangan }}" class="w-full px-2 py-1 border rounded-md">
                            </td>
                            <td class="px-3 py-2 text-center">
                                <button type="button" onclick="hapusRow(this)"
                                    class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                        @php $index++; @endphp
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                <button type="button" onclick="tambahRow()"
                    class="px-4 py-2 bg-green-500 text-white rounded-md shadow hover:bg-green-600">
                    + Tambah Pekerjaan
                </button>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded-md shadow hover:bg-yellow-600">
                    Update
                </button>

                <a href="{{ route('vendor.dokumenba.index', 'BAPP') }}"
                    class="px-4 py-2 bg-gray-400 text-white rounded-md shadow hover:bg-gray-500">
                    Batal
                </a>
            </div>

        </form>
    </div>

    <script>
        let index = {{ $index }};

        function tambahRow() {
            const table = document.querySelector('#pekerjaan-table tbody');
            const row = `
        <tr class="border-b hover:bg-gray-50">
            <td class="px-3 py-2"><input type="text" name="pekerjaan[${index}][uraian]" required class="w-full px-2 py-1 border rounded-md"></td>
            <td class="px-3 py-2"><input type="text" name="pekerjaan[${index}][spesifikasi]" required class="w-full px-2 py-1 border rounded-md"></td>
            <td class="px-3 py-2">
                <select name="pekerjaan[${index}][status]" required class="w-full px-2 py-1 border rounded-md">
                    <option value="Selesai">Selesai</option>
                    <option value="Belum Selesai">Belum Selesai</option>
                </select>
            </td>
            <td class="px-3 py-2"><input type="text" name="pekerjaan[${index}][keterangan]" class="w-full px-2 py-1 border rounded-md"></td>
            <td class="px-3 py-2 text-center">
                <button type="button" onclick="hapusRow(this)" class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600">Hapus</button>
            </td>
        </tr>
    `;
            table.insertAdjacentHTML("beforeend", row);
            index++;
        }

        function hapusRow(btn) {
            if (!confirm("Apakah Anda yakin ingin menghapus pekerjaan ini?")) return;
            btn.closest("tr").remove();
        }

        document.getElementById('bapp-form').addEventListener('submit', function(e) {
            const ok = confirm("Apakah Anda yakin ingin mengupdate data BAPP ini?");
            if (!ok) e.preventDefault();
        });
    </script>

@endsection
