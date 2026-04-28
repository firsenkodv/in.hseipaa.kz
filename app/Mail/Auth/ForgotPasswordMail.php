<?php

namespace App\Mail\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $formattedData;

    public function __construct(array $user)
    {
        $this->formattedData = $user;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Запрос на смену пароля'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'html.email.forgot_password',
            with: ['user' => $this->formattedData]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
