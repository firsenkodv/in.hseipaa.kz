<?php

namespace App\Mail\Contract;

use App\Enums\OrganizationEnum;
use App\Models\Contract;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContractSignedMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $contractData;

    public function __construct(Contract $contract, ?string $signedIp = null)
    {
        $orgEnum = $contract->organizations
            ? OrganizationEnum::fromValueSafe($contract->organizations)
            : null;

        $manager = $contract->relationLoaded('user')
            ? $contract->user?->Manager
            : $contract->user()->with('Manager')->first()?->Manager;

        $this->contractData = [
            'contract_number'        => $contract->contract_number,
            'fio'                    => $contract->full_name,
            'email'                  => $contract->email,
            'phone'                  => $contract->phone,
            'training_id'            => $contract->discipline,
            'date_from'              => $contract->date_start?->format('d.m.Y'),
            'date_to'                => $contract->date_end?->format('d.m.Y'),
            'price'                  => $contract->price,
            'currency'               => $contract->currency,
            'hours'                  => $contract->hours,
            'organization_label'     => $orgEnum?->label(),
            'organization_logo'      => $orgEnum ? asset($orgEnum->logo()) : null,
            'organization_logo_size' => $orgEnum?->logoSize(),
            'manager_name'           => $manager?->username,
            'manager_email'          => $manager?->email,
            'manager_phone'          => $manager?->phone ? format_phone($manager->phone) : null,
            'signed_at'              => $contract->updated_at?->format('d.m.Y в H:i'),
            'signed_ip'              => $signedIp,
        ];
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ваш договор успешно подписан'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'html.email.contract_signed',
            with: ['contract' => $this->contractData]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
