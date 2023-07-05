<?php

namespace App\Http\Controllers;

use App\Events\EmailChanged;
use App\Http\Requests\UpdateEmailRequest;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ChangeEmailController extends Controller
{
    public function __invoke(UpdateEmailRequest $request, User $user)

    {
        if($user->email == $request->email){
            return handleResponse('Email is same as before', 409, 'error');
        }
        event(new EmailChanged($user, $request->email));

        return handleResponse('To complete email change please confirm it in your mailbox of new mail', 200, 'success');
    }
}
