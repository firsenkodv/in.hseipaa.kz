<?php

namespace App\Listeners\Form;

use App\Events\Form\FancyBoxSendingFromFormEvent;
use App\Jobs\Form\FancyBoxSendingFromFormJob;
use Illuminate\Support\Facades\Mail;
use Support\Traits\CreatorToken;
use Support\Traits\EmailAddressCollector;

class FancyBoxSendingFromFormHandlerListener
{
    use EmailAddressCollector;
    use CreatorToken;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     * сообщение
     */
    public function handle(FancyBoxSendingFromFormEvent $event): void
    {
        FancyBoxSendingFromFormJob::dispatch($event->request); // Job
        //Mail::to($this->emails())->send(new AccreditationMail($data));


    }
}
