<?php

namespace App\Listeners;

use App\Events\OurExampleEvent;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OurExamplelistener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OurExampleEvent $event)
    {
        Log::debug("the user {$event->username} has {$event->action}");
    }
}
