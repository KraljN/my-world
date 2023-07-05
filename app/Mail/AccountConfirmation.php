<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    private string $first_name;
    private int $user_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($first_name, $user_id)
    {
        $this->first_name = $first_name;
        $this->user_id = $user_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Confirm your My World account')->markdown('emails.activation')->with([
            'user_id' => $this->user_id,
            'first_name' => $this->first_name
        ]);
    }
}
