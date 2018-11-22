<?php

namespace App\Policies;

use App\Appointment;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppointmentPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->isVerified() && !$user->isSuspended();
    }

    public function edit(User $user, Appointment $appointment)
    {
        return $appointment->user_id == $user->id || $appointment->doctor_id == $user->id;
    }

    public function delete(User $user, Appointment $appointment)
    {
        return $appointment->user_id == $user->id;
    }
}
