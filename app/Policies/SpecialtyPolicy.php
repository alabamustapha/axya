<?php

namespace App\Policies;

use App\User;
use App\Specialty;
use Illuminate\Auth\Access\HandlesAuthorization;

class SpecialtyPolicy
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
     * Determine whether the user can edit/update the specialty.
     *
     * @param  \App\User  $user
     * @param  \App\Specialty  $specialty
     * @return mixed
     */
    public function edit(User $user, Specialty $specialty)
    {
        return ($specialty->user_id == auth()->id() && $user->isDoctor()) || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the specialty.
     *
     * @param  \App\User  $user
     * @param  \App\Specialty  $specialty
     * @return mixed
     */
    public function delete(User $user, Specialty $specialty)
    {
        return $user->isAdmin();
    }
}
