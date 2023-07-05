<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactMessageReply extends Mailable
{
    use Queueable, SerializesModels, softDelete;

    private string $response;
    private string $first_name;
    private string $admin_username;
    private string $text;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($response, $first_name, $admin_username, $text)
    {
        $this->text = $text;
        $this->response = $response;
        $this->first_name = $first_name;
        $this->admin_username = $admin_username;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.contact-message-reply')
            ->subject('Reply on My-World contact message')
            ->with([
            'text' => $this->text,
            'first_name' => $this->first_name,
            'admin_username' => $this->admin_username,
            'response' => $this->response
        ]);
    }
}
