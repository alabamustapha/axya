<?php

namespace App\Policies;

use App\User;
use App\Specialty;
use Illuminate\Auth\Access\HandlesAuthorization;

class SpecialtyPolicy
{
    use HandlesAuthorization;

    public function view(User $user)
    {
        # Used only within the Nova Admin Section.
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can create specialties.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin();
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
        return $user->isAdmin();
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
