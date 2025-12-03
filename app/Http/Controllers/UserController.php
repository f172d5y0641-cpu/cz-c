<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // ============================================================
    // ===============           API SECTION           ============
    // ============================================================

    public function index()
    {
        return User::all(); // API list user
    }

    public function store(Request $request)
    {
        $user = User::create($request->all());
        return response()->json($user, 201); // API create user
    }

    public function show($id)
    {
        return User::findOrFail($id); // API show user
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json($user, 200); // API update user
    }

    public function destroy($id)
    {
        User::destroy($id);
        return response()->json(null, 204); // API delete user
    }


    //CRUD User

    public function pageIndex()
    {
        $users = User::paginate(10);
        return view('admin.user.index', compact('users'));
    }

    public function pageCreate()
    {
        return view('admin.user.create');
    }

    public function pageStore(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.user.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    public function pageEdit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    public function pageUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'  => 'required',
            'email' => "required|email|unique:users,email,$id",
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $request->validate(['password' => 'min:6']);
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.user.index')
            ->with('success', 'User berhasil diperbarui');
    }

    public function pageDestroy($id)
    {
        User::destroy($id);

        return redirect()->route('admin.user.index')
            ->with('success', 'User berhasil dihapus');
    }
}
