<?php

namespace App\Http\Controllers\Auth;

use \App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasswordChangeController extends Controller
{
    public function __invoke(User $user, UpdatePasswordRequest $request){
        try{

            if(!Hash::check($request->old_password, $user->password)){
                return handleResponse('You old password is not correct', 401, 'error');
            }
            $user->password = Hash::make($request->new_password);
            $user->save();

            return handleResponse('Password successfully changed.', 204, 'success');
        }
        catch (\Error | \Exception $ex){
            return handleResponse('There has been error while changing password', 500, 'error', $ex);
        }

    }
}
