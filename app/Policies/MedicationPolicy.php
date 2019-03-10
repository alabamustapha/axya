<?php

namespace App\Policies;

use App\Medication;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MedicationPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->isVerified() && !$user->isSuspended();
    }

    public function edit(User $user, Medication $medication)
    {
        return $user->id == $medication->user_id;
    }

    public function delete(User $user, Medication $medication)
    {
        return $user->id == $medication->user_id;
    }
}
