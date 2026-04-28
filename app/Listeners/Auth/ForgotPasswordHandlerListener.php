<?php

namespace App\Listeners\Auth;

use App\Events\Auth\ForgotPasswordEvent;
use App\Mail\Auth\ForgotPasswordMail;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordHandlerListener
{
    public function __construct()
    {
        //
    }

    public function handle(ForgotPasswordEvent $event): void
    {
        Mail::to($event->user['email'])->send(new ForgotPasswordMail($event->user));
    }
}
