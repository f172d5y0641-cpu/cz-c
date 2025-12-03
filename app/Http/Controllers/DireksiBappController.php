<?php

namespace App\Http\Controllers;

use App\Models\DokumenBA;
use App\Models\Approval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DireksiBappController extends Controller
{
  // Menampilkan daftar BAPP
  public function index()
  {
    $bappList = DokumenBA::where('jenis_dokumen', 'BAPP')->get();

    return view('direksi.bapp.index', compact('bappList'));
  }

  // Menampilkan detail BAPP
  public function detail($id_ba)
  {
    $ba = DokumenBA::with(['bapp', 'approval'])->findOrFail($id_ba);

    return view('direksi.bapp.detail-periksa', compact('ba'));
  }

  // Halaman periksa BAPP (form approve/reject)
  public function periksa($id_ba)
  {
    $ba = DokumenBA::with(['bapp', 'approval'])->findOrFail($id_ba);

    return view('direksi.bapp.periksa', compact('ba'));
  }

  public function submitPeriksa(Request $request, $id_ba)
  {
    $request->validate([
      'status' => 'required|in:accepted,rejected',
      'catatan' => 'nullable|string',
      'signature_image' => 'nullable|string', // Base64 dari canvas
    ]);

    $approvalData = [
      'id_users' => Auth::id(),
      'status' => $request->status,
      'tanggal_approval' => now(),
      'catatan' => $request->catatan,
    ];

    // Simpan TTD hanya jika status accepted
    if ($request->status === 'accepted' && $request->signature_image) {
      $image = $request->signature_image;
      $image = str_replace('data:image/png;base64,', '', $image);
      $image = str_replace(' ', '+', $image);
      $imageName = 'signatures/direksi_' . $id_ba . '_' . time() . '.png';
      Storage::disk('public')->put($imageName, base64_decode($image));
      $approvalData['tanda_tangan'] = $imageName;
    }

    // Update atau buat approval baru
    Approval::updateOrCreate(
      ['id_ba' => $id_ba, 'id_users' => Auth::id()],
      $approvalData
    );

    // Update status BA
    DokumenBA::where('id_ba', $id_ba)->update([
      'status' => $request->status
    ]);

    return redirect()->route('direksi.bapp.index')->with('success', 'BAPP berhasil diperiksa dan TTD tersimpan.');
  }
}
