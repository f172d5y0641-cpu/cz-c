@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-4">Tambah User</h1>

<form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
    @csrf

    <div>
        <label>Nama</label>
        <input type="text" name="name" class="w-full p-2 border rounded">
    </div>

    <div>
        <label>Email</label>
        <input type="email" name="email" class="w-full p-2 border rounded">
    </div>

    <div>
        <label>Password</label>
        <input type="password" name="password" class="w-full p-2 border rounded">
    </div>

    <div>
        <label>Role</label>
        <select name="role" class="w-full p-2 border rounded">
            <option value="admin">Admin</option>
            <option value="vendor">Vendor</option>
            <option value="pic_gudang">PIC Gudang</option>
            <option value="direksi">Direksi</option>
        </select>
    </div>

    <button class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
</form>
@endsection
