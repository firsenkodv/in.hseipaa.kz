<?php

namespace App\Mail\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserRegisteredMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public array $userData) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ваш аккаунт зарегистрирован'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'html.email.user_registered',
            with: ['user' => $this->userData]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
