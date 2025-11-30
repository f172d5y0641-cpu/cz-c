<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Notifikasi Approval BAPB</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f5f5f5; }
        .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; text-align: center; color: white; }
        .content { padding: 30px; }
        .footer { background: #f8f9fa; padding: 20px; text-align: center; color: #6c757d; font-size: 12px; }
        .status-badge { padding: 8px 16px; border-radius: 20px; font-weight: bold; display: inline-block; margin: 10px 0; }
        .status-menunggu { background: #fff3cd; color: #856404; border: 1px solid #ffeaa7; }
        .status-diterima { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
        .status-ditolak { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .info-box { background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .button { display: inline-block; padding: 12px 24px; background: #667eea; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; }
        .alert-box { background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 5px; margin: 15px 0; }
    </style>
</head>
<body>
    <table width="100%" cellpadding="0" cellspacing="0" style="background: #f5f5f5; padding: 40px 0;">
        <tr>
            <td align="center">
                <div class="container">
                    <!-- Header -->
                    <div class="header">
                        <h1 style="margin: 0; font-size: 24px;">📄digiBA</h1>
                        <p style="margin: 5px 0 0 0; opacity: 0.9;">Notifikasi Approval Berita Acara</p>
                    </div>
                    
                    <!-- Content -->
                    <div class="content">
                        <h2 style="color: #333; margin-top: 0;">Notifikasi Status Approval</h2>
                        
                        <!-- Status Badge -->
                        @if($data['status'] === 'menunggu_verifikasi')
                            <div class="status-badge status-menunggu">
                                ⏳ MENUNGGU VERIFIKASI
                            </div>
                            <p>Berita Acara telah ditandatangani dan menunggu verifikasi approval.</p>
                        @elseif($data['status'] === 'diterima')
                            <div class="status-badge status-diterima">
                                ✅ BAPB DITERIMA
                            </div>
                            <p>Selamat! Berita Acara telah disetujui dan diterima.</p>
                        @elseif($data['status'] === 'ditolak')
                            <div class="status-badge status-ditolak">
                                ❌ BAPB DITOLAK
                            </div>
                            <p>Berita Acara memerlukan perbaikan sebelum dapat disetujui.</p>
                        @endif

                        <!-- Info Box -->
                        <div class="info-box">
                            <h3 style="margin-top: 0; color: #495057;">📋 Detail Berita Acara</h3>
                            <table style="width: 100%;">
                                <tr>
                                    <td style="padding: 8px 0; color: #6c757d; width: 40%;">Nomor BAPB:</td>
                                    <td style="padding: 8px 0; font-weight: bold;">{{ $data['nomor_bapb'] }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; color: #6c757d;">Judul Project:</td>
                                    <td style="padding: 8px 0; font-weight: bold;">{{ $data['judul_project'] }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; color: #6c757d;">Dibuat Oleh:</td>
                                    <td style="padding: 8px 0; font-weight: bold;">{{ $data['pembuat'] }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; color: #6c757d;">Tanggal:</td>
                                    <td style="padding: 8px 0; font-weight: bold;">{{ $data['tanggal'] }}</td>
                                </tr>
                            </table>
                        </div>

                        <!-- Catatan atau Alasan Penolakan -->
                        @if($data['status'] === 'ditolak' && $data['alasan_penolakan'])
                            <div class="alert-box">
                                <h4 style="margin: 0 0 10px 0; color: #856404;">📝 Alasan Penolakan:</h4>
                                <p style="margin: 0; color: #856404;">{{ $data['alasan_penolakan'] }}</p>
                            </div>
                        @endif

                        @if($data['status'] === 'menunggu_verifikasi')
                            <div class="alert-box">
                                <p style="margin: 0;">⚠️ <strong>Penting:</strong> Silakan verifikasi dan berikan approval untuk dokumen ini.</p>
                            </div>
                        @endif

                        <!-- Attachment Info -->
                        @if($data['status'] === 'diterima')
                            <div style="background: #d1edff; padding: 15px; border-radius: 5px; margin: 15px 0;">
                                <h4 style="margin: 0 0 10px 0; color: #0c5460;">📎 Lampiran:</h4>
                                <p style="margin: 0; color: #0c5460;">
                                    Berita Acara (PDF) telah dilampirkan dalam email ini. 
                                    File telah ditandatangani secara digital dan bersifat resmi.
                                </p>
                            </div>
                        @endif

                        <!-- Action Button -->
                        <p style="text-align: center; margin: 25px 0;">
                            <a href="{{ $data['link_approval'] }}" class="button">
                                @if($data['status'] === 'menunggu_verifikasi')
                                    👉 Verifikasi Sekarang
                                @else
                                    👉 Lihat Detail
                                @endif
                            </a>
                        </p>

                        <p style="color: #6c757d; font-size: 14px; text-align: center;">
                            Email otomatis • Jangan balas email ini<br>
                            Dikirim pada: {{ now()->format('d/m/Y H:i') }}
                        </p>
                    </div>
                    
                    <!-- Footer -->
                    <div class="footer">
                        <p style="margin: 0;">&copy; {{ date('Y') }} digiBA</p>
                        <p style="margin: 5px 0 0 0;">Sistem Management Berita Acara Digital</p>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>