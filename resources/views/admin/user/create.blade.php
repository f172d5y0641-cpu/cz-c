@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-md">
    <h1 class="text-2xl font-bold mb-6">Tambah User Baru</h1>
    
    <form action="{{ route('admin.users.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
        @csrf
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Nama</label>
            <input type="text" name="name" required 
                   class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                   placeholder="Masukkan nama lengkap">
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Email</label>
            <input type="email" name="email" required 
                   class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                   placeholder="contoh@email.com">
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Password</label>
            <input type="password" name="password" required 
                   class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                   placeholder="Minimal 6 karakter">
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 mb-2">Role</label>
            <select name="role" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Pilih Role</option>
                <option value="admin">Admin</option>
                <option value="direksi">Direksi</option>
                <option value="vendor">Vendor</option>
                <option value="pic-gudang">PIC Gudang</option>
                <option value="user">User Biasa</option>
            </select>
        </div>
        
        <div class="flex gap-3">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition">
                Simpan User
            </button>
            <a href="{{ route('admin.users.index') }}" 
               class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection