<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

class AdminCreateUserVerification extends VerifyEmail
{
    protected ?string $plainPassword;

    public function __construct(?string $plainPassword = null)
    {
        $this->plainPassword = $plainPassword;
    }

    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            [
                'id'   => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }

    protected function resolveRole($user): array
    {
        return match ((int) $user->role_id) {
            4 => [
                'label' => 'Peserta PKL',
                'title' => 'Akun Peserta PKL Anda Telah Dibuat',
            ],
            5 => [
                'label' => 'Peserta Magang',
                'title' => 'Akun Peserta Magang Anda Telah Dibuat',
            ],
            default => [
                'label' => 'Pengguna',
                'title' => 'Akun Anda Telah Dibuat',
            ],
        };
    }

    public function toMail($notifiable)
    {
        $role = $this->resolveRole($notifiable);

        return (new MailMessage)
            ->subject($role['title'])
            ->view('auth.admin-created-user', [
                'user'      => $notifiable,
                'password'  => $this->plainPassword,
                'url'       => $this->verificationUrl($notifiable),
                'roleLabel' => $role['label'],
                'title'     => $role['title'],
            ]);
    }
}
