<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AdminGuruStatusNotification extends Notification
{
    use Queueable;

    protected $status;
    protected $reason;

    public function __construct(string $status, string $reason = null) {
        $this->status = $status;
        $this->reason = $reason;
    }

    public function via($notifiable) {
        return ['mail'];
    }

    public function toMail($notifiable) {
        return (new MailMessage)
            ->subject($this->status === 'approved' ? 'Akun Guru Disetujui' : 'Akun Guru Ditolak')
            ->view('auth.notifguru', [
                'user' => $notifiable,
                'status' => $this->status,
                'reason' => $this->reason,
                'title' => $this->status === 'approved' ? 'Akun Disetujui' : 'Akun Ditolak'
            ]);
    }
    
}