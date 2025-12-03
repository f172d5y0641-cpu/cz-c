@extends('layouts.picgudang')

@section('content')

<h1 class="font-semibold text-4xl text-gray-700 mb-4">Periksa Detail BAPB</h1>

<a href="{{ route('pic-gudang.bapb.periksa') }}"
    class="inline-block bg-blue-500 text-white px-4 py-2 rounded-md mb-5 hover:bg-blue-600 transition">
    ← Kembali
</a>

<div class="bg-white shadow-md rounded-lg p-6 mb-6">
    <h2 class="text-xl font-semibold text-blue-700 mb-3">Informasi BAPB</h2>

    <table class="w-full border-collapse">
        <tr>
            <th class="text-left p-3 bg-blue-100 w-1/4">Nama Vendor</th>
            <td class="p-3">{{ $bapb->nama_vendor }}</td>
        </tr>

        <tr>
            <th class="text-left p-3 bg-blue-100">Jabatan</th>
            <td class="p-3">{{ $bapb->jabatan }}</td>
        </tr>

        <tr>
            <th class="text-left p-3 bg-blue-100">Perusahaan</th>
            <td class="p-3">{{ $bapb->perusahaan }}</td>
        </tr>

        <tr>
            <th class="text-left p-3 bg-blue-100">Alamat</th>
            <td class="p-3">{{ $bapb->alamat }}</td>
        </tr>

        <tr>
            <th class="text-left p-3 bg-blue-100">Nomor Kontrak</th>
            <td class="p-3">{{ $bapb->nomor_kontrak }}</td>
        </tr>

        <tr>
            <th class="text-left p-3 bg-blue-100">Status</th>
            <td class="p-3">
                <span class="status {{ $bapb->status }}">
                    {{ ucfirst($bapb->status) }}
                </span>
            </td>
        </tr>
    </table>
</div>

<div class="bg-white shadow-md rounded-lg p-6">
    <h2 class="text-xl font-semibold text-blue-700 mb-3">Daftar Barang</h2>

    <div class="overflow-x-auto rounded-lg ">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-blue-600 text-white">
                    <th class="p-3 text-left">Nama Barang</th>
                    <th class="p-3 text-left">Merk/Type</th>
                    <th class="p-3 text-center">Jumlah</th>
                    <th class="p-3 text-center">Kondisi</th>
                    <th class="p-3 text-left">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bapb->barang as $b)
                <tr class="bg-white border-b">
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

<div x-data="{ valid: '' }" class="bg-white p-4 shadow rounded-lg mt-6">
    <h2 class="text-xl font-semibold mb-3">Apakah BAPB sudah valid?</h2>
    <label>
        <input type="radio" name="valid" value="setujui" x-model="valid"> Setujui
    </label>
    <br>
    <label>
        <input type="radio" name="valid" value="tolak" x-model="valid"> Tolak
    </label>

    <!-- Jika Setuju -->
    <div x-show="valid === 'setujui'" class="mt-4">
        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Setujui & TTD Otomatis
        </button>
    </div>

    <!-- Jika Tolak -->
    <div x-show="valid === 'tolak'" class="mt-4">
        <textarea class="w-full border p-2 rounded" rows="3"
            placeholder="Tuliskan alasan penolakan..."></textarea>

        <button class="mt-2 bg-red-600 text-white px-4 py-2 rounded">
            Kirim Penolakan
        </button>
    </div>
</div>
@endsection
