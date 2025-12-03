<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DokumenBA;

class DireksiDashboardController extends Controller
{
    public function index()
    {
        // Statistik
        $totalBapp = DokumenBA::where('jenis_dokumen', 'BAPP')->count();
        $pending = DokumenBA::where('jenis_dokumen', 'BAPP')
            ->whereIn('status', ['submitted', 'pending'])
            ->count();
        $approved = DokumenBA::where('jenis_dokumen', 'BAPP')
            ->whereIn('status', ['accepted', 'approved'])
            ->count();
        $rejected = DokumenBA::where('jenis_dokumen', 'BAPP')
            ->where('status', 'rejected')
            ->count();

        // Ambil maksimal 5 data terbaru untuk preview di dashboard
        $dokumen = DokumenBA::where('jenis_dokumen', 'BAPP')
            ->latest()
            ->take(5)
            ->get();

        return view('direksi.dashboard', compact('totalBapp', 'pending', 'approved', 'rejected', 'dokumen'));
    }

    public function riwayat(Request $request)
    {
        $query = DokumenBA::where('jenis_dokumen', 'BAPP');

        // Fitur search berdasarkan nama vendor, nomor kontrak, atau status
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_vendor', 'like', "%$search%")
                    ->orWhere('nomor_kontrak', 'like', "%$search%")
                    ->orWhere('status', 'like', "%$search%");
            });
        }

        $dokumen = $query->latest()->paginate(10)->withQueryString();

        return view('direksi.riwayat', compact('dokumen'));
    }
}
