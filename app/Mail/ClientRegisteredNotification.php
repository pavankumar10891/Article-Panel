<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientRegisteredNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $clientInfo;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($clientInfo)
    {
        $this->clientInfo = $clientInfo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.clientRegisteredNotification');
    }
}
