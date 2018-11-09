<?php

namespace App\Policies;

use App\User;
use App\Workplace;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkplacePolicy
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
     * Determine whether the user can edit/update the workplace.
     *
     * @param  \App\User  $user
     * @param  \App\Workplace  $workplace
     * @return mixed
     */
    public function edit(User $user, Workplace $workplace)
    {
        return ($workplace->user_id == auth()->id() && $user->isDoctor()) || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the workplace.
     *
     * @param  \App\User  $user
     * @param  \App\Workplace  $workplace
     * @return mixed
     */
    public function delete(User $user, Workplace $workplace)
    {
        return ($workplace->user_id == auth()->id() && $user->isDoctor()) || $user->isAdmin();
    }
}
