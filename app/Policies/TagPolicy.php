<?php

namespace App\Policies;

use App\User;
use App\Tag;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create specialties.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isDoctor() || $user->isAdmin();
    }

    /**
     * Determine whether the user can edit/update the tag.
     *
     * @param  \App\User  $user
     * @param  \App\Tag  $tag
     * @return mixed
     */
    public function edit(User $user, Tag $tag)
    {
        return ($tag->user_id == auth()->id() && $user->isDoctor()) || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the tag.
     *
     * @param  \App\User  $user
     * @param  \App\Tag  $tag
     * @return mixed
     */
    public function delete(User $user, Tag $tag)
    {
        return $user->isAdmin();
    }
}
