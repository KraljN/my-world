<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactMessageRequest;
use App\Http\Requests\ReplyContactMessageRequest;
use \App\Mail\ContactMessageReply as ContactMessageReplyMail;
use App\Models\ContactMessage;
use App\Models\ContactMessageReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactMessageController extends UserBasicController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('contact', $this->data);
    }

    public function reply(ContactMessage $contactMessage, ReplyContactMessageRequest $request){
        try{
             ContactMessageReply::create([
                'text' => $request->text,
                 'user_id' => auth()->id(),
                 'contact_message_id' => $contactMessage->id
            ]);

            Mail::to($contactMessage->email)->send(new ContactMessageReplyMail($request->text, $contactMessage->name, auth()->user()->username, $contactMessage->text));
            return handleResponse('Contact message successfully replied.', 201, 'success');
        }
        catch (\Error | \Exception $ex){
            return handleResponse('There has been error while replying to contact message', 500, 'error', $ex);
        }
    }

    public function adminIndex(){
        $this->data['contact_messages'] =  ContactMessage::with('reply', 'reply.user')->paginate(5);

        if(request()->expectsJson()){
            return handleResponse('success', 200, 'success', $this->data['contact_messages']);
        }

        return view('admin.contact-message', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactMessageRequest $request)
    {
        try{
            $contactMessage = ContactMessage::create([
                'name' => $request->name,
                'email' => $request->email,
                'text' => $request->text
            ]);
            return handleResponse('Contact message successfully sent.', 201, 'success', $contactMessage);
        }
        catch (\Error | \Exception $ex){
            return handleResponse('There has been error while sending contact message', 500, 'error', $ex);
        }
    }
}
