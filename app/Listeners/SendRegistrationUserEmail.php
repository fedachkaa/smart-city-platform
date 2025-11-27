<?php

namespace App\Listeners;

use App\Mail\RegistrationUserSuccessMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendRegistrationUserEmail implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        Mail::to($event->user->email)->queue(new RegistrationUserSuccessMail($event->user));
    }
}