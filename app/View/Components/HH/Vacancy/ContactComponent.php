<?php

namespace App\View\Components\HH\Vacancy;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ContactComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public readonly mixed $user,
        public readonly mixed $item,
    ) {}

    public function render(): View|Closure|string
    {
        $creator = $this->item?->user;

        $contact = (object) [
            'phone'    => $this->item->phone    ?: ($creator?->phone    ?? null),
            'email'    => $this->item->email    ?: ($creator?->email    ?? null),
            'whatsapp' => $this->item->whatsapp ?: ($creator?->whatsapp ?? null),
            'telegram' => $this->item->telegram ?: ($creator?->telegram ?? null),
            'address' => $this->item->address ?: '',
        ];

        $hasTarif = $this->user && $this->user->hasTarif;

        return view('components.h-h.vacancy.contact-component', [
            'creator'  => $creator,
            'contact'  => $contact,
            'hasTarif' => $hasTarif,
        ]);
    }

}
