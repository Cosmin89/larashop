<?php

namespace larashop\Listeners\Social;

use Mail;
use larashop\Events\Social\GoogleAccountWasLinked;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendGoogleLinkedEmail
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
     * @param  GoogleAccountWasLinked  $event
     * @return void
     */
    public function handle(GoogleAccountWasLinked $event)
    {
         Mail::to($event->user)->send(new GoogleAccountLinked($event->user));
    }
}
