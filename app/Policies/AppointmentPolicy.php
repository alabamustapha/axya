<?php

namespace App\Policies;

use App\Schedule;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppointmentPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->isVerified() && !$user->isSuspended();
    }

    public function edit(User $user, Schedule $schedule)
    {
        return $schedule->user_id === $user->id || $schedule->doctor_id === $user->id;
    }
}
