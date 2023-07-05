<?php

namespace App\Listeners;

use App\Events\EmailChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailNotification
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
     * @param  \App\Events\EmailChanged  $event
     * @return void
     */
    public function handle(EmailChanged $event)
    {
        if($event->user->email != $event->new_email){
            $event->user->sendEmailChangeNotification($event->new_email);
        }
    }
}
