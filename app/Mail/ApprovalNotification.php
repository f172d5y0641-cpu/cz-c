<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApprovalNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $pdfPath;

    public function __construct($data = [], $pdfPath = null)
    {
        $this->data = array_merge([
            'status' => 'menunggu_verifikasi',
            'nomor_bapb' => '',
            'judul_project' => '',
            'pembuat' => '',
            'catatan' => '',
            'tanggal' => now()->format('d F Y'),
            'link_approval' => url('/'),
            'alasan_penolakan' => ''
        ], $data);

        $this->pdfPath = $pdfPath;
    }

    public function build()
    {
        $email = $this->subject($this->getSubject())
                      ->view('mails.approval-notification');

        // Jika status DITERIMA dan ada file PDF, attach file
        if ($this->data['status'] === 'diterima' && $this->pdfPath && file_exists($this->pdfPath)) {
            $email->attach($this->pdfPath, [
                'as' => 'Berita_Acara_' . $this->data['nomor_bapb'] . '.pdf',
                'mime' => 'application/pdf'
            ]);
        }

        return $email;
    }

    private function getSubject()
    {
        $statusMap = [
            'menunggu_verifikasi' => 'Menunggu Verifikasi',
            'diterima' => 'Diterima',
            'ditolak' => 'Ditolak'
        ];

        $statusText = $statusMap[$this->data['status']] ?? 'Notifikasi';
        
        return "[BAPB {$this->data['nomor_bapb']}] Status: {$statusText} - {$this->data['judul_project']}";
    }
}