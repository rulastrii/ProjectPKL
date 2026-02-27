<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PengajuanMagangStatusNotification extends Notification
{
    use Queueable;

    protected $pdfData;
    protected $no_surat;
    protected $ttd;

    public function __construct(
        protected string $status,
        protected ?string $reason = null,
        $pdfData = null,      // optional PDF content
        $no_surat = null,
        $ttd = null
    ) {
        $this->pdfData = $pdfData;
        $this->no_surat = $no_surat;
        $this->ttd = $ttd;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $title = match ($this->status) {
            'draft'     => 'Pengajuan Magang Dibuat',
            'diproses'  => 'Pengajuan Magang Diproses',
            'diterima'  => 'Pengajuan Magang Diterima',
            'ditolak'   => 'Pengajuan Magang Ditolak',
            'selesai'   => 'Magang Telah Selesai',
            default     => 'Status Pengajuan Magang',
        };

        $mail = (new MailMessage)
            ->subject($title)
            ->view('auth.pengajuan-magang-status', [
                'title'     => $title,
                'pengajuan' => $notifiable,
                'status'    => $this->status,
                'reason'    => $this->reason,
            ]);

        // Tambahkan PDF attachment jika ada
        if ($this->pdfData && $this->no_surat) {
            $mail->attachData($this->pdfData, "Surat-Balasan-{$this->no_surat}.pdf");
        }

        return $mail;
    }
}
