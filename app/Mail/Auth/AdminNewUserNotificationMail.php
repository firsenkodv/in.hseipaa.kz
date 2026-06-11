<?php

namespace App\Mail\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminNewUserNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public array $userData) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Зарегистрирован новый пользователь'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'html.email.admin_new_user',
            with: ['user' => $this->userData]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
