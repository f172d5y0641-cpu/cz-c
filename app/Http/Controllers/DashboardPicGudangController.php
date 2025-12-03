<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DokumenBA;

class DashboardPicGudangController extends Controller
{
    public function index()
    {
        // hitung data
        $totalBapb = DokumenBA::where('jenis_dokumen', 'BAPB')->count();
        $belumDiperiksa = DokumenBA::where('jenis_dokumen', 'BAPB')->where('status', 'pending')->count();
        $disetujui = DokumenBA::where('jenis_dokumen', 'BAPB')->where('status', 'accepted')->count();
        $ditolak = DokumenBA::where('jenis_dokumen', 'BAPB')->where('status', 'rejected')->count();

        // progres
        $progres = $totalBapb > 0 ? round((($disetujui + $ditolak) / $totalBapb) * 100): 0;

        return view('pic-gudang.dashboard', compact('totalBapb', 'belumDiperiksa', 'disetujui', 'ditolak', 'progres'));
    }
}
