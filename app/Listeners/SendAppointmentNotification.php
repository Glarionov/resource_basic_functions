<?php

namespace App\Listeners;

use App\Events\AppointmentCreated;
use App\Mail\AppointmentNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendAppointmentNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\AppointmentCreated  $event
     * @return void
     */
    public function handle(AppointmentCreated $event)
    {
        Mail::to($event->appointment->email)->send(new AppointmentNotification($event->appointment));
    }
}
