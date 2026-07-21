<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailNotification extends VerifyEmail
{
    /**
     * Override the default Laravel verification email
     * with our custom Monarch Hotel branded template.
     *
     * $this->notifiable is set by the Notification base class
     * before toMail() is called — we receive the notifiable here.
     */
    public function toMail($notifiable): MailMessage
    {
        $url = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Verify Your Email — Monarch Hotel')
            ->view('emails.verify-email', [
                'url'  => $url,
                'user' => $notifiable,
            ]);
    }
}
