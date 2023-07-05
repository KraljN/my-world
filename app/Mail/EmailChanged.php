<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailChanged extends Mailable
{
    use Queueable, SerializesModels;

    private string $first_name;
    private int $user_id;
    private string $new_email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($first_name, $user_id, $new_email)
    {
        $this->first_name = $first_name;
        $this->user_id = $user_id;
        $this->new_email = $new_email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Confirm your new Email Address')->markdown('emails.change-email')->with([
            'user_id' => $this->user_id,
            'first_name' => $this->first_name,
            'new_email' => $this->new_email
        ]);
    }
}
