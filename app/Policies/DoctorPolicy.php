<?php

namespace App\Policies;

use App\User;
use App\Doctor;
use Illuminate\Auth\Access\HandlesAuthorization;

class DoctorPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the doctor can edit the profile.
     *
     * @param  \App\Doctor  $doctor
     * @return boolean
     */
    public function edit(User $user, Doctor $doctor)
    {
        return $doctor->id === $user->id;
    }

    public function create(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the doctor can delete the resource.
     *
     * @param  \App\Doctor  $doctor
     * @return mixed
     */
    public function delete(User $user, Doctor $doctor)
    {
        return (($doctor->id === $user->id) || $user->isSuperAdmin());
    }
}
