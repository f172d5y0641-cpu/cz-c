<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DokumenBA;
use App\Models\Bapb;
use App\Models\Bapp;
use App\Models\Approval;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use setasign\Fpdi\Fpdi;

class DokumenBAPdfController extends Controller
{
    public function show(DokumenBA $dokumen) 
    {
        $latestApproval = Approval::where('id_ba', $dokumen->id_ba)
            ->whereNotNull('file_dokumen')
            ->latest()
            ->first();

        if ($latestApproval && !empty($latestApproval->file_dokumen)) {
            $path = $latestApproval->file_dokumen;

            if (Str::startsWith($path, ['http://', 'https://'])) {
                return redirect()->away($path);
            }

            $normalizedPath = ltrim(preg_replace('#^(storage|public)/#', '', $path), '/');
            $disk = Storage::disk('public');
            if ($disk->exists($normalizedPath)) {
                $fullPath = $disk->path($normalizedPath);
                return response()->file($fullPath, ['Content-Type' => 'application/pdf']);
            }
        }

        // Jika belum ada approval tersimpan, pastikan PDF dasar tersedia lalu tampilkan
        $basePath = $this->generateBasePdfIfMissing($dokumen);
        $disk = Storage::disk('public');
        $normalized = ltrim(preg_replace('#^(storage|public)/#', '', $basePath), '/');
        if ($disk->exists($normalized)) {
            return response()->file($disk->path($normalized), ['Content-Type' => 'application/pdf']);
        }

        abort(404, 'PDF tidak ditemukan.');
    }

    public function download(DokumenBA $dokumen)
    {
        $jenis = strtolower($dokumen->jenis_dokumen);

        if ($jenis === 'bapb') {
            $view = 'pdfs.bapb';
        } elseif ($jenis === 'bapp') {
            $view = 'pdfs.bapp';
        } else {
            $view = 'pdfs.dokumen';
        }

        $pdf = Pdf::loadView($view, [
            'dokumen' => $dokumen,
            'date' => Carbon::parse($dokumen->created_at),
        ])
            ->setPaper('A4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true)
            ->setOption('defaultFont', 'Helvetica');

        return $pdf->download("dokumen-{$dokumen->id}.pdf");
    }

    public function sign(Request $request, DokumenBA $dokumen)
    {
        try {
            $request->validate([
                'stampX' => 'required|numeric',
                'stampY' => 'required|numeric',
                'canvasHeight' => 'required|numeric|min:1',
                'canvasWidth' => 'required|numeric|min:1',
                'signature_image' => 'required|string',
                'stampWidth' => 'nullable|numeric|min:1',
                'stampHeight' => 'nullable|numeric|min:1',
            ]);
            
            $user = Auth::user();
            
            $signatureData = $request->input('signature_image');
            $signatureData = str_replace('data:image/png;base64,', '', $signatureData);
            $signatureData = str_replace(' ', '+', $signatureData);
            
            $signatureBinary = base64_decode($signatureData);
            if ($signatureBinary === false) {
                return back()->with('error', 'Tanda tangan tidak valid.');
            }

            $disk = Storage::disk('public');
            $disk->makeDirectory('signatures');
            $disk->makeDirectory('approvals');

            $signatureFile = "signatures/signature-{$dokumen->id_ba}-" . time() . ".png";
            if (!$disk->put($signatureFile, $signatureBinary)) {
                return back()->with('error', 'Gagal menyimpan tanda tangan.');
            }
            
            $canvasWidth = max(1, floatval($request->input('canvasWidth')));
            $canvasHeight = max(1, floatval($request->input('canvasHeight')));
            $stampX = floatval($request->input('stampX'));
            $stampY = floatval($request->input('stampY'));
            $stampWidthPx = max(1, floatval($request->input('stampWidth', 160)));
            $stampHeightPx = max(1, floatval($request->input('stampHeight', 80)));
            
            $basePath = $this->generateBasePdfIfMissing($dokumen);
            $baseNormalized = ltrim(preg_replace('#^(storage|public)/#', '', $basePath), '/');
            if (!$disk->exists($baseNormalized)) {
                return back()->with('error', 'PDF dasar tidak ditemukan.');
            }

            $baseFullPath = $disk->path($baseNormalized);
            $signatureFullPath = $disk->path($signatureFile);
            [$imgWidthPx, $imgHeightPx] = @getimagesize($signatureFullPath) ?: [$stampWidthPx, $stampHeightPx];
            $imgWidthPx = $stampWidthPx ?: $imgWidthPx;
            $imgHeightPx = $stampHeightPx ?: $imgHeightPx;

            $fpdi = new Fpdi();
            $pageCount = $fpdi->setSourceFile($baseFullPath);

            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $tplIdx = $fpdi->importPage($pageNo);
                $size = $fpdi->getTemplateSize($tplIdx);
                $orientation = ($size['width'] > $size['height']) ? 'L' : 'P';

                $fpdi->addPage($orientation, [$size['width'], $size['height']]);
                $fpdi->useTemplate($tplIdx);

                if ($pageNo === $pageCount) {
                    $realX = ($stampX / $canvasWidth) * $size['width'];
                    $realY = ($stampY / $canvasHeight) * $size['height'];
                    $realWidth = ($imgWidthPx / $canvasWidth) * $size['width'];
                    $realHeight = ($imgHeightPx / $canvasHeight) * $size['height'];

                    $fpdi->Image($signatureFullPath, $realX, $realY, $realWidth, $realHeight);
                }
            }

            $fileName = "approval-{$dokumen->id_ba}-" . time() . ".pdf";
            $filePath = "approvals/{$fileName}";
            $stampedPdf = $fpdi->Output('S');

            if (!$disk->put($filePath, $stampedPdf)) {
                return back()->with('error', 'Gagal menyimpan dokumen yang telah ditandatangani.');
            }

            Approval::create([
                'id_ba' => $dokumen->id_ba,
                'id_users' => $user->id,
                'status' => 'signed',
                'tanggal_approval' => now(),
                'file_dokumen' => $filePath,
                'tanda_tangan' => $signatureFile,
            ]);

            return back()->with('success', 'Dokumen berhasil ditandatangani.');
        } catch (\Throwable $e) {
            Log::error('Gagal menandatangani dokumen', [
                'error' => $e->getMessage(),
                'dokumen_id' => $dokumen->id_ba,
            ]);
            return back()->with('error', 'Terjadi kesalahan saat memproses tanda tangan.');
        }
    }

    private function generateBasePdfIfMissing(DokumenBA $dokumen): string
    {
        $disk = Storage::disk('public');

        if (!empty($dokumen->file_dokumen)) {
            $path = ltrim(preg_replace('#^(storage|public)/#', '', $dokumen->file_dokumen), '/');
            if ($disk->exists($path)) {
                return $path;
            }
        }

        $jenis = strtolower($dokumen->jenis_dokumen);
        $view = 'pdfs.dokumen';
        $data = [
            'dokumen' => $dokumen,
            'date' => Carbon::parse($dokumen->created_at),
        ];

        if ($jenis === 'bapb') {
            $view = 'pdfs.bapb';
            $data['bapb'] = Bapb::where('id_ba', $dokumen->id_ba)->get();
        } elseif ($jenis === 'bapp') {
            $view = 'pdfs.bapp';
            $data['bapp'] = Bapp::where('id_ba', $dokumen->id_ba)->get();
        }

        $pdf = Pdf::loadView($view, $data)
            ->setPaper('A4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true)
            ->setOption('defaultFont', 'Helvetica');

        $fileName = "dokumen-{$dokumen->id_ba}.pdf";
        $filePath = "dokumen_ba/{$fileName}";

        $disk->put($filePath, $pdf->output());
        $dokumen->file_dokumen = $filePath;
        $dokumen->save();

        return $filePath;
    }
}
