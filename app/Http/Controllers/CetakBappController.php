<?php

namespace App\Http\Controllers;

use App\Models\DokumenBA;
use App\Models\Approval;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class CetakBappController extends Controller
{
  public function print($id_ba)
  {
    $dokumen = DokumenBA::with(['bapp', 'user'])->findOrFail($id_ba);

    // 1. AMBIL DATA TTD VENDOR
    $vendorApproval = Approval::where('id_ba', $id_ba)
      ->where('id_users', $dokumen->id_users)
      ->first();

    $signatureData = null;
    if ($vendorApproval && $vendorApproval->tanda_tangan) {
      $meta = json_decode($vendorApproval->catatan, true);
      $path = public_path('storage/' . $vendorApproval->tanda_tangan);

      $signatureData = [
        'path' => $path,
        'left' => isset($meta['x']) ? ($meta['x'] / ($meta['canvas_w'] ?? 500)) * 100 : 70,
        'top'  => isset($meta['y']) ? ($meta['y'] / ($meta['canvas_h'] ?? 800)) * 100 : 80,
        'width' => $meta['w'] ?? 100
      ];
    }

    // 2. AMBIL DATA TTD DIREKSI
    $direksiApproval = Approval::where('id_ba', $id_ba)
      ->where('id_users', '!=', $dokumen->id_users)
      ->where('status', 'accepted') // atau approved
      ->first();

    $direksiSignaturePath = null;
    if ($direksiApproval && $direksiApproval->tanda_tangan) {
      $direksiSignaturePath = public_path('storage/' . $direksiApproval->tanda_tangan);
    }

    $namaDireksi = $direksiApproval ? $direksiApproval->user->name : 'Direksi Utama';

    // 3. GENERATE PDF (PERBAIKAN DISINI)
    // Ubah 'pdf.bapp' menjadi 'pdfs.bapp' sesuai nama foldermu
    $pdf = Pdf::loadView('pdfs.bapp', [
      'dokumen' => $dokumen,
      'bapp' => $dokumen->bapp ?? collect(),
      'date' => now(),
      'signature' => $signatureData,
      'direksiSignature' => $direksiSignaturePath,
      'namaDireksi' => $namaDireksi
    ]);

    $pdf->setPaper('A4', 'portrait');

    return $pdf->stream('BAPP_' . $dokumen->nomor_kontrak . '.pdf');
  }
}
