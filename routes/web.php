<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\DashboardVendorController;
use App\Http\Controllers\DashboardPicGudangController;
use App\Http\Controllers\PemeriksaanBapbController;
use App\Http\Controllers\DokumenBAController;
use App\Http\Controllers\DokumenBAPdfController;
use App\Http\Controllers\CetakBappController;
use App\Http\Controllers\DireksiDashboardController;
use App\Http\Controllers\DireksiBappController;
use App\Http\Controllers\SignatureController;
use App\Http\Controllers\PicGudangController;
use App\Mail\ApprovalNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('auth.login');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

/*
|--------------------------------------------------------------------------
| EMAIL TESTING ROUTES (Development Only)
|--------------------------------------------------------------------------
*/
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

Route::get('test-email-diterima', function() {
    $pdfPath = storage_path('app/public/bapb/BAPB_2024_015.pdf');
    
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

/*
|--------------------------------------------------------------------------
| CETAK / EXPORT ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/bapp/{id_ba}/cetak', [CetakBappController::class, 'print'])->name('bapp.print');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    
    // User Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'pageIndex'])->name('index');
        Route::get('/create', [UserController::class, 'pageCreate'])->name('create');
        Route::post('/create', [UserController::class, 'pageStore'])->name('store');
        Route::get('/edit/{id}', [UserController::class, 'pageEdit'])->name('edit');
        Route::put('/edit/{id}', [UserController::class, 'pageUpdate'])->name('update');
        Route::delete('/delete/{id}', [UserController::class, 'pageDestroy'])->name('delete');
    });
    
    // Dokumen BA Management
    Route::prefix('dokumen-ba')->name('dokumen-ba.')->group(function () {
        Route::get('/', [DokumenBAController::class, 'adminIndex'])->name('index');
        Route::get('/{id}', [DokumenBAController::class, 'show'])->name('show');
        Route::delete('/{id}', [DokumenBAController::class, 'destroy'])->name('destroy');
    });
});

/*
|--------------------------------------------------------------------------
| DIREKSI ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:direksi'])->prefix('direksi')->name('direksi.')->group(function () {
    Route::get('/dashboard', [DireksiDashboardController::class, 'index'])->name('dashboard');
    Route::get('/riwayat', [DireksiDashboardController::class, 'riwayat'])->name('riwayat');
    
    // BAPP Routes
    Route::get('/bapp', [DireksiBappController::class, 'index'])->name('bapp.index');
    Route::get('/bapp/{id_ba}', [DireksiBappController::class, 'detail'])->name('bapp.detail');
    Route::get('/bapp/{id_ba}/periksa', [DireksiBappController::class, 'periksa'])->name('bapp.periksa');
    Route::post('/bapp/{id_ba}/periksa', [DireksiBappController::class, 'submitPeriksa'])->name('bapp.submit_periksa');
});

/*
|--------------------------------------------------------------------------
| VENDOR ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::get('/', [DashboardVendorController::class, 'index'])->name('dashboard');
    
    // Dokumen BA Management
    Route::prefix('dokumen')->name('dokumenba.')->group(function () {
        Route::get('/{jenis}', [DokumenBAController::class, 'index'])->name('index');
        Route::get('/{jenis}/create', [DokumenBAController::class, 'create'])->name('create');
        Route::post('/', [DokumenBAController::class, 'store'])->name('store');
        Route::get('/{dokumen}/edit', [DokumenBAController::class, 'edit'])->name('edit');
        Route::get('/{dokumen}/detail', [DokumenBAController::class, 'show'])->name('show');
        Route::put('/{dokumen}', [DokumenBAController::class, 'update'])->name('update');
        Route::get('/{dokumen}/kirim', [DokumenBAController::class, 'kirim'])->name('pdf.kirim');
        Route::delete('/{dokumen}', [DokumenBAController::class, 'destroy'])->name('destroy');
    });
    
    // PDF Management
    Route::prefix('dokumen')->name('dokumen.pdf.')->group(function () {
        Route::get('/{dokumen}/pdf', [DokumenBAPdfController::class, 'show'])->name('preview');
        Route::get('/{dokumen}/pdf/download', [DokumenBAPdfController::class, 'download'])->name('download');
        Route::post('/{dokumen}/pdf/sign', [DokumenBAPdfController::class, 'sign'])->name('sign');
    });
    
    // Shortcut Routes
    Route::prefix('bapb')->name('bapb.')->group(function () {
        Route::get('/', [DokumenBAController::class, 'index'])->defaults('jenis', 'bapb');
        Route::get('/create', [DokumenBAController::class, 'create'])->defaults('jenis', 'bapb');
    });
    
    Route::prefix('bapp')->name('bapp.')->group(function () {
        Route::get('/', [DokumenBAController::class, 'index'])->defaults('jenis', 'bapp');
        Route::get('/create', [DokumenBAController::class, 'create'])->defaults('jenis', 'bapp');
        Route::get('/{id}', [DokumenBAController::class, 'show'])->name('show');
    });
    
    // Additional Pages
    Route::get('pengaturan', [DashboardVendorController::class, 'pengaturan'])->name('pengaturan');
});

/*
|--------------------------------------------------------------------------
| PIC GUDANG ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:pic-gudang'])->prefix('pic-gudang')->name('pic-gudang.')->group(function () {
    Route::get('/', [DashboardPicGudangController::class, 'index'])->name('dashboard');
    
    // BAPB Management
    Route::prefix('bapb')->name('bapb.')->group(function () {
        Route::get('/', [PemeriksaanBapbController::class, 'index'])->name('index');
        Route::get('/pemeriksaan', [PemeriksaanBapbController::class, 'periksaList'])->name('periksa');
        Route::get('/pemeriksaan/detail-periksa/{id_ba}', [PemeriksaanBapbController::class, 'detail'])->name('detail-periksa');
        Route::post('/{id_ba}/accept', [PemeriksaanBapbController::class, 'accept'])->name('accept');
        Route::post('/{id_ba}/reject', [PemeriksaanBapbController::class, 'reject'])->name('reject');
    });
    
    // Signature Management
    Route::prefix('signature')->name('signature.')->group(function () {
        Route::get('/', [SignatureController::class, 'create'])->name('create');
        Route::post('/', [SignatureController::class, 'store'])->name('store');
    });
});

/*
|--------------------------------------------------------------------------
| SIGNATURE ROUTES (Global)
|--------------------------------------------------------------------------
*/
Route::get('/signature-pad', [SignatureController::class, 'index'])->name('signature.index');
Route::post('/signature-pad', [SignatureController::class, 'store'])->name('signature.store');

/*
|--------------------------------------------------------------------------
| UTILITY ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/generate-pass', function () {
    return bcrypt('admin123');
});