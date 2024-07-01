<?php

namespace App\Listeners;

use App\Events\ClientRegistered;
use App\Mail\ClientRegisteredNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendClientRegisteredEmailNotification
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
     * @param  \App\Events\ClientRegistered  $event
     * @return void
     */
    public function handle(ClientRegistered $event)
    {
        $clientInfo = $event->user;

        Mail::to($clientInfo->email, $clientInfo->name)
            ->send(new ClientRegisteredNotification($clientInfo));
    }
}
