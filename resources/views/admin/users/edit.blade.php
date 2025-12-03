@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-4">Edit User</h1>

<form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label>Nama</label>
        <input type="text" name="name" value="{{ $user->name }}" class="w-full p-2 border rounded">
    </div>

    <div>
        <label>Email</label>
        <input type="email" name="email" value="{{ $user->email }}" class="w-full p-2 border rounded">
    </div>

    <div>
        <label>Password (kosongkan jika tidak diganti)</label>
        <input type="password" name="password" class="w-full p-2 border rounded">
    </div>

    <div>
        <label>Role</label>
        <select name="role" class="w-full p-2 border rounded">
            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="vendor" {{ $user->role == 'vendor' ? 'selected' : '' }}>Vendor</option>
            <option value="pic_gudang" {{ $user->role == 'pic_gudang' ? 'selected' : '' }}>PIC Gudang</option>
            <option value="direksi" {{ $user->role == 'direksi' ? 'selected' : '' }}>Direksi</option>
        </select>
    </div>

    <button class="px-4 py-2 bg-blue-600 text-white rounded">Perbarui</button>
</form>
@endsection
