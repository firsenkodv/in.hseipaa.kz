<?php

namespace App\Mail\Contract;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContractCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public array $contractData) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Для вас оформлен договор на обучение'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'html.email.contract_created',
            with: ['contract' => $this->contractData]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
