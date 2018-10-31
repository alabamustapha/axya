<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can edit the profile.
     *
     * @param  \App\User  $user
     * @return boolean
     */
    public function edit(User $user)
    {
        return $user->isAccountOwner();
    }

    /**
     * Determine whether the user can delete the resource.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        return ($user->isAccountOwner() || $user->isSuperAdmin());
    }
}
