@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-4">Kelola User</h1>

<a href="{{ route('admin.users.create') }}"
   class="px-4 py-2 bg-blue-600 text-white rounded mb-4 inline-block">
    + Tambah User
</a>

<table class="w-full bg-white shadow rounded">
    <thead>
        <tr class="bg-gray-200 text-left">
            <th class="p-3">Nama</th>
            <th class="p-3">Email</th>
            <th class="p-3">Role</th>
            <th class="p-3">Aksi</th>
        </tr>
    </thead>

    <tbody>
        @foreach($users as $user)
        <tr class="border-b">
            <td class="p-3">{{ $user->name }}</td>
            <td class="p-3">{{ $user->email }}</td>
            <td class="p-3">{{ $user->role }}</td>
            <td class="p-3 flex gap-2">
                <a href="{{ route('admin.users.edit', $user->id) }}"
                   class="px-3 py-1 bg-yellow-500 text-white rounded">Edit</a>

                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                      onsubmit="return confirm('Yakin hapus user?')">
                    @csrf
                    @method('DELETE')
                    <button class="px-3 py-1 bg-red-600 text-white rounded">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
