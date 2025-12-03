<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DokumenBA;

class PemeriksaanBapbController extends Controller
{
    // menampilkan semua status bapb
    public function index()
    {
        $bapb = DokumenBA::where('jenis_dokumen', 'BAPB')->get();
        return view('pic-gudang.bapb.index', compact('bapb'));
    }

    // menampilkan bapb yg belum diperiksa
    public function periksaList()
    {
        $bapb = DokumenBA::where('jenis_dokumen', 'BAPB')->where('status', 'pending')->get();
        return view('pic-gudang.bapb.periksa', compact('bapb'));
    }

    // halaman detail untuk memeriksa
    public function detail($id_ba)
    {
        $bapb = DokumenBA::findOrFail($id_ba);
        return view('pic-gudang.bapb.detail-periksa', compact('bapb'));
    }

    // bapb accept
    public function accept($id_ba)
    {
        $bapb = DokumenBA::findOrFail($id_ba);
        $bapb->status = 'accepted';
        $bapb->save();

        return redirect()->route('pic-gudang.bapb.periksa')->with('success', 'BAPB disetujui');
    }

    // bapb reject
    public function reject($id_ba, Request $request)
    {
        $bapb = DokumenBA::findOrFail($id_ba);
        $bapb->status = 'rejected';
        $bapb->save();

        return redirect()->route('pic-gudang.bapb.periksa')->with('success', 'BAPB ditolak');
    }
}
