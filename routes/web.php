<?php

use Illuminate\Support\Facades\Route;
use App\Mail\ApprovalNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

// Test Email Menunggu Verifikasi
Route::get('test-email-menunggu', function() {
    $data = [
        'status' => 'menunggu_verifikasi',
        'nomor_bapb' => 'BAPB/2024/015',
        'judul_project' => 'Pengembangan Website Company Profile',
        'pembuat' => ' - Project Manager',
        'tanggal' => '1 Desember 2024',
        'link_approval' => url('/approval/15')
    ];

    Mail::to('ferytogatorop725@gmail.com')
        ->send(new ApprovalNotification($data));

    return "Email notifikasi MENUNGGU VERIFIKASI berhasil dikirim!";
});

// Test Email Diterima + Attachment PDF
Route::get('test-email-diterima', function() {
    // Simulasikan path file PDF (ganti dengan path file BAPB yang sebenarnya)
    $pdfPath = storage_path('app/public/bapb/BAPB_2024_015.pdf');
    
    // Jika file tidak ada, buat dummy file untuk testing
    if (!file_exists($pdfPath)) {
        Storage::put('public/bapb/BAPB_2024_015.pdf', 'Sample PDF Content - Berita Acara Digital');
    }

    $data = [
        'status' => 'diterima',
        'nomor_bapb' => 'BAPB/2024/015',
        'judul_project' => 'Pengembangan Website Company Profile',
        'pembuat' => 'Project Manager',
        'tanggal' => '1 Desember 2024',
        'link_approval' => url('/documents/15')
    ];

    Mail::to('ferytogatorop725@gmail.com')
        ->send(new ApprovalNotification($data, $pdfPath));

    return "Email notifikasi DITERIMA + PDF berhasil dikirim!";
});

// Test Email Ditolak
Route::get('test-email-ditolak', function() {
    $data = [
        'status' => 'ditolak',
        'nomor_bapb' => 'BAPB/2024/015',
        'judul_project' => 'Pengembangan Website Company Profile',
        'pembuat' => '- Project Manager',
        'tanggal' => '1 Desember 2024',
        'alasan_penolakan' => 'Terdapat ketidaksesuaian pada item deliverable nomor 3. Mohon diperbaiki dan sesuaikan dengan kontrak awal.',
        'link_approval' => url('/documents/15/edit')
    ];

    Mail::to('ferytogatorop725@gmail.com')
        ->send(new ApprovalNotification($data));

    return "Email notifikasi DITOLAK berhasil dikirim!";
});