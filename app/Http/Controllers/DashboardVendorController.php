<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DokumenBA;
use Illuminate\Support\Facades\Auth;

class DashboardVendorController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->search;
        $jenis = $request->jenis_dokumen;
        $status = $request->status;

        // Query builder
        $dokumen = DokumenBA::query();
        $dokumen->where('id_users', $user->id);

        if ($search) {
            $dokumen->where(function ($q) use ($search) {
                $q->where('nama_vendor', 'LIKE', "%$search%")
                    ->orWhere('nomor_kontrak', 'LIKE', "%$search%");
            });
        }

        if ($jenis) {
            $dokumen->where('jenis_dokumen', $jenis);
        }

        if ($status) {
            $dokumen->where('status', $status);
        }

        $dokumen = $dokumen->orderBy('created_at', 'desc')->get();

        $totalBapb = DokumenBA::where('id_users', $user->id)->where('jenis_dokumen', 'BAPB')->count();
        $totalBapp = DokumenBA::where('id_users', $user->id)->where('jenis_dokumen', 'BAPP')->count();
        $menungguPersetujuan = DokumenBA::where('id_users', $user->id)->where('status', 'pending')->count();
        $disetujui = DokumenBA::where('id_users', $user->id)->where('status', 'approved')->count();

        return view('vendor.dashboard', compact(
            'dokumen',
            'totalBapb',
            'totalBapp',
            'menungguPersetujuan',
            'disetujui'
        ));
    }
}
