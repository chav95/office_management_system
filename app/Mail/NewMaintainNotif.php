<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Maintenance;

class NewMaintainNotif extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $doc;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Maintenance $doc)
    {
        $this->doc = $doc;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('New Maintenance')
            ->markdown('mails.new_maintain_notif');
    }
}
