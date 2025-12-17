<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PengajuanMagangStatusNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected string $status,
        protected ?string $reason = null
    ) {}

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

    return (new MailMessage)
        ->subject($title)
        ->view('auth.pengajuan-magang-status', [
            'title'     => $title,
            'pengajuan' => $notifiable,
            'status'    => $this->status,
            'reason'    => $this->reason,
        ]);
}

}