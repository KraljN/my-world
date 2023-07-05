<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    public function update(User $authUser, User $user)
    {
        if($authUser->id == $user->id || $authUser->hasRole('admin')) return true;
        return Response::deny("You can't edit other user if you are not admin");
    }
}
