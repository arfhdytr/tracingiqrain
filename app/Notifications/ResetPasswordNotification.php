<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // 1. Ambil email (karena email ada di tabel mentor, kita ambil dari method custom)
        $email = $notifiable->getEmailForPasswordReset();

        // 2. Buat Link Reset Password
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $email, // Sertakan email di link agar otomatis terisi
        ], false));

        // 3. Panggil View HTML yang kita buat di Langkah 1
        return (new MailMessage)
            ->subject('Reset Password - IQRAIN') // Judul Email di Inbox
            ->view('emails.reset-password', ['url' => $url]);
    }
}
