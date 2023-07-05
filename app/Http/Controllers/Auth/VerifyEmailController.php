<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UserBasicController;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerifyEmailController extends UserBasicController
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(EmailVerificationRequest $request)
    {
        $request->user()->markEmailAsVerified();

        return redirect()->route('verification.notice');
    }

    public function confirmChange(\Illuminate\Http\Request $request, $id, $hash, $email){
        $request->user()->changeEmail($email);

        $request->user()->load('image');
        $this->authorize('update', $request->user());
        $this->data['user'] = $request->user();
        $this->data['message'] = 'New Address Confirmed';
        return view('users.edit', $this->data);
    }

    public function resend(User $user){
        $user->sendEmailVerificationNotification();

        return handleResponse("Email verification successfully sent to {$user->email}.", 200, 'success');
    }


}
