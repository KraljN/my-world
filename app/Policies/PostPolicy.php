<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function adminView(User $user){
        return $user->hasRole(['admin', 'writer']);
    }

    public function edit(User $user,Post $post){
        return $user->hasRole(['admin']) || $post->user_id == $user->id;
    }
}
