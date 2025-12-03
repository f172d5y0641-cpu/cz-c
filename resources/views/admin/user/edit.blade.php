@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-md">
    <h1 class="text-2xl font-bold mb-6">Edit User</h1>
    
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                   class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                   class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Password (kosongkan jika tidak diubah)</label>
            <input type="password" name="password" 
                   class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                   placeholder="Kosongkan jika tidak ingin mengubah">
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 mb-2">Role</label>
            <select name="role" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="direksi" {{ $user->role == 'direksi' ? 'selected' : '' }}>Direksi</option>
                <option value="vendor" {{ $user->role == 'vendor' ? 'selected' : '' }}>Vendor</option>
                <option value="pic-gudang" {{ $user->role == 'pic-gudang' ? 'selected' : '' }}>PIC Gudang</option>
                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User Biasa</option>
            </select>
        </div>
        
        <div class="flex gap-3">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition">
                Update User
            </button>
            <a href="{{ route('admin.users.index') }}" 
               class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection