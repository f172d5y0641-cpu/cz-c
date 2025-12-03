<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Redirect user berdasarkan role yang tersimpan di database.
     */
    private function redirectTo($role)
    {
        switch ($role) {
            case 'vendor':
                return redirect()->route('vendor.dashboard');

            case 'pic-gudang':
                return redirect()->route('pic-gudang.dashboard');

            case 'direksi':
                return redirect()->route('direksi.dashboard');

            case 'admin':
                return redirect()->route('admin.dashboard');

            default:
                abort(403, 'User does not have the right roles.');
        }
    }

    /**
     * Menampilkan halaman login.
     */
    public function login()
    {
        return view('login');
    }

    /**
     * Proses autentikasi user.
     */
    public function authenticate(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'User does not exist!');
        }

        // Cek password
        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Password wrong!');
        }

        // Login user
        Auth::login($user);

        // AMBIL ROLE ASLI USER DARI DATABASE (bukan dari input!)
        $role = $user->getRoleNames()->first();

        if (!$role) {
            return back()->with('error', 'User has no roles assigned!');
        }

        // Redirect berdasarkan role
        return $this->redirectTo($role);
    }

    /**
     * Logout user.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
