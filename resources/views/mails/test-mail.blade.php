<!DOCTYPE html>
<html>
<head>
    <title>Notifikasi Approval Dokumen</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { max-width: 600px; margin: 0 auto; }
        .alert { background: #FFF3CD; border: 1px solid #FFEAA7; padding: 15px; border-radius: 5px; }
        .success { background: #D1ECF1; border: 1px solid #BEE5EB; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Notifikasi Approval Dokumen</h2>
        
        <div class="alert">
            <h3>📋 Dokumen Memerlukan Approval Anda</h3>
        </div>

        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #ddd;"><strong>Jenis Dokumen:</strong></td>
                <td style="padding: 10px; border-bottom: 1px solid #ddd;">Berita Acara Serah Terima</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #ddd;"><strong>Nomor:</strong></td>
                <td style="padding: 10px; border-bottom: 1px solid #ddd;">BAP/2024/001</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #ddd;"><strong>Project:</strong></td>
                <td style="padding: 10px; border-bottom: 1px solid #ddd;">Website Development</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #ddd;"><strong>Dibuat Oleh:</strong></td>
                <td style="padding: 10px; border-bottom: 1px solid #ddd;">Admin Project</td>
            </tr>
        </table>

        <p style="margin-top: 20px;">
            <a href="{{ url('/approval/1') }}" 
               style="background: #28A745; color: white; padding: 12px 20px; text-decoration: none; border-radius: 5px;">
               👉 Review Dokumen
            </a>
        </p>

        <p><small>Email ini dikirim oleh sistem Digi BA pada {{ now()->format('d/m/Y H:i') }}</small></p>
    </div>
</body>
</html>