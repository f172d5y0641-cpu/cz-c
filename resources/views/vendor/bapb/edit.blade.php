@extends('layouts.vendor')

@section('title', 'Edit BAPB')

@section('content')

<h1 class="text-2xl font-semibold mb-6">Edit BAPB</h1>

<div class="bg-white p-6 rounded-lg shadow-md border">
    <form action="{{ route('vendor.dokumenba.update', $dokumen->id_ba) }}" method="POST" id="ba-form">
        @csrf
        @method('PUT')

        <input type="hidden" name="jenis_dokumen" value="BAPB">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label class="block mb-1 font-medium">Nama Vendor</label>
                <input type="text" name="nama_vendor" value="{{ $dokumen->nama_vendor }}" required
                    class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-300">
            </div>

            <div>
                <label class="block mb-1 font-medium">Jabatan</label>
                <input type="text" name="jabatan" value="{{ $dokumen->jabatan }}" required
                       class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-300">
            </div>

            <div>
                <label class="block mb-1 font-medium">Perusahaan</label>
                <input type="text" name="perusahaan" value="{{ $dokumen->perusahaan }}" required
                       class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-300">
            </div>

            <div>
                <label class="block mb-1 font-medium">Alamat</label>
                <input type="text" name="alamat" value="{{ $dokumen->alamat }}" required
                       class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-300">
            </div>

            <div>
                <label class="block mb-1 font-medium">Nomor Kontrak</label>
                <input type="text" name="nomor_kontrak" value="{{ $dokumen->nomor_kontrak }}" required
                       class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-300">
            </div>

            <div>
                <label class="block mb-1 font-medium">Nilai Barang</label>
                <input type="number" step="0.01" name="nilai_pekerjaan" value="{{ $dokumen->nilai_pekerjaan }}" required
                    class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-300">
            </div>

            <div class="md:col-span-2">
                <label class="block mb-1 font-medium">Deskripsi</label>
                <textarea name="deskripsi_pekerjaan" rows="3" required
                    class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring focus:ring-blue-300">{{ $dokumen->deskripsi_pekerjaan }}</textarea>
            </div>

        </div>

        <hr class="my-6">

        <h3 class="text-lg font-semibold mb-3">Daftar Barang</h3>

        <table class="w-full border-collapse bg-white shadow rounded-md overflow-hidden" id="barang-table">
            <thead>
                <tr class="bg-blue-100">
                    <th class="px-3 py-3 text-left">Nama Barang</th>
                    <th class="px-3 py-3 text-left">Merk/Type</th>
                    <th class="px-3 py-3 text-left">Jumlah</th>
                    <th class="px-3 py-3 text-left">Kondisi</th>
                    <th class="px-3 py-3 text-left">Keterangan</th>
                    <th class="px-3 py-3 text-left">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($dokumen->barang as $i => $b)
                <tr class="border-b">
                    <td class="px-3 py-2">
                        <input type="text" name="barang[{{ $i }}][nama]" value="{{ $b->nama_barang }}" required
                               class="w-full px-2 py-1 border rounded-md">
                    </td>

                    <td class="px-3 py-2">
                        <input type="text" name="barang[{{ $i }}][merk]" value="{{ $b->merk_type }}" required
                               class="w-full px-2 py-1 border rounded-md">
                    </td>

                    <td class="px-3 py-2">
                        <input type="number" name="barang[{{ $i }}][jumlah]" value="{{ $b->jumlah }}" required
                               class="w-full px-2 py-1 border rounded-md">
                    </td>

                    <td class="px-3 py-2">
                        <select name="barang[{{ $i }}][kondisi]" required class="w-full px-2 py-1 border rounded-md">
                            <option value="Baik"  {{ $b->kondisi == 'Baik' ? 'selected' : '' }}>Baik</option>
                            <option value="Rusak" {{ $b->kondisi == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                        </select>
                    </td>

                    <td class="px-3 py-2">
                        <input type="text" name="barang[{{ $i }}][keterangan]" value="{{ $b->keterangan }}"
                               class="w-full px-2 py-1 border rounded-md">
                    </td>

                    <td class="px-3 py-2">
                        <button type="button"
                                class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600"
                                onclick="hapusRow(this)">
                            Hapus
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            <button type="button"
                class="px-4 py-2 bg-green-500 text-white rounded-md shadow hover:bg-green-600"
                onclick="tambahRow()">
                + Tambah Barang
            </button>
        </div>

        <div class="flex gap-3 mt-8">
            <button type="submit"
                class="px-4 py-2 bg-yellow-500 text-white rounded-md shadow hover:bg-yellow-600"
                id="btn-update">
                Update
            </button>

            <a href="{{ route('vendor.bapb.index') }}"
               class="px-4 py-2 bg-gray-400 text-white rounded-md shadow hover:bg-gray-500">
                Batal
            </a>
        </div>

    </form>
</div>

<script>
let index = {{ count($dokumen->barang) }};

function tambahRow() {
    const table = document.querySelector('#barang-table tbody');
    const row = `
        <tr class="border-b">
            <td class="px-3 py-2"><input type="text" name="barang[${index}][nama]" required class="w-full px-2 py-1 border rounded-md"></td>
            <td class="px-3 py-2"><input type="text" name="barang[${index}][merk]" required class="w-full px-2 py-1 border rounded-md"></td>
            <td class="px-3 py-2"><input type="number" name="barang[${index}][jumlah]" required class="w-full px-2 py-1 border rounded-md"></td>
            <td class="px-3 py-2">
                <select name="barang[${index}][kondisi]" class="w-full px-2 py-1 border rounded-md" required>
                    <option value="Baik">Baik</option>
                    <option value="Rusak">Rusak</option>
                </select>
            </td>
            <td class="px-3 py-2"><input type="text" name="barang[${index}][keterangan]" class="w-full px-2 py-1 border rounded-md"></td>
            <td class="px-3 py-2">
                <button type="button" onclick="hapusRow(this)"
                    class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600">
                    Hapus
                </button>
            </td>
        </tr>
    `;
    table.insertAdjacentHTML('beforeend', row);
    index++;
}

function hapusRow(btn) {
    if (!confirm("Apakah Anda yakin ingin menghapus barang ini?")) return;
    btn.closest('tr').remove();
}

document.getElementById('ba-form').addEventListener('submit', function(e) {
    const ok = confirm("Apakah Anda yakin ingin mengupdate data ini?");
    if (!ok) e.preventDefault();
});
</script>

@endsection
