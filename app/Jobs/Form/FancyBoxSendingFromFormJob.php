<?php

namespace App\Jobs\Form;

use App\Mail\Form\AccreditationMail;
use App\Mail\Form\FancyBoxSendingFromFormMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Support\Traits\CreatorToken;
use Support\Traits\EmailAddressCollector;

class FancyBoxSendingFromFormJob implements ShouldQueue
{
    use Queueable;

    use EmailAddressCollector;
    use CreatorToken;

    public function __construct(public  array $data)
    {

    }


    public function handle(): void
    {
        Mail::to($this->emails())->send(new FancyBoxSendingFromFormMail($this->data));

    }

}
