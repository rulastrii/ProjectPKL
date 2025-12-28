<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\PengajuanPklmagang;

class PengajuanPklStatusNotification extends Notification
{
    use Queueable;

    public function __construct(
        protected string $status,
        protected ?string $reason = null,
        protected ?PengajuanPklmagang $pengajuan = null
    ) {}

    public function via($notifiable) {
        return ['mail'];
    }

    public function toMail($notifiable) {
        $title = match ($this->status) {
            'draft'     => 'Pengajuan PKL Dibuat',
            'proses'    => 'Pengajuan PKL Diproses',
            'disetujui' => 'Pengajuan PKL Disetujui',
            'ditolak'   => 'Pengajuan PKL Ditolak',
            'selesai'   => 'PKL Telah Selesai',
            default     => 'Status Pengajuan PKL',
        };

        $pengajuan = $this->pengajuan;

        return (new MailMessage)
            ->subject($title)
            ->view('auth.pengajuan-pkl-status', [
                'title'     => $title,
                'pengajuan' => $pengajuan,
                'status'    => $this->status,
                'reason'    => $this->reason,
            ]);
    }
}
