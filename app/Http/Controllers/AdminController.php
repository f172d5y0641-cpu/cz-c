<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DokumenBA;

class AdminController extends Controller
{
    // Ubah nama fungsi dari 'dashboard' ke 'index' agar sesuai dengan Route
    public function index()
    {
        // CARA BENAR MENGHITUNG USER DENGAN SPATIE
        // Gunakan scope 'role' bawaan Spatie, bukan 'where' kolom.

        $total_vendor = User::role('vendor')->count();

        // Perbaikan: Gunakan 'pic-gudang' (sesuai database/seeder), bukan 'pic gudang'
        $total_pic = User::role('pic-gudang')->count();

        $total_direksi = User::role('direksi')->count();

        // Cek Dokumen (Logika Anda sudah oke, saya rapikan sedikit)
        $total_dokumen = 0;
        $latest_dokumen = collect();

        if (class_exists(DokumenBA::class)) {
            $total_dokumen = DokumenBA::count();
            $latest_dokumen = DokumenBA::latest()->limit(5)->get();
        }

        return view('admin.dashboard', compact(
            'total_vendor',
            'total_pic',
            'total_direksi',
            'total_dokumen',
            'latest_dokumen'
        ));
    }
}
