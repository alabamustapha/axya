<?php

namespace App\Policies;

use App\Message;
use App\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->isVerified();
    }

    /**
     * Determine whether the user can delete the message.
     *
     * @param  \App\User  $user
     * @param  \App\Message  $message
     * @return mixed
     */
    public function delete(User $user, Message $message)
    {
        // Available for delete within 45minutes of posting.
        return $user->id == $message->user_id || $user->isAdmin();
    }
}
