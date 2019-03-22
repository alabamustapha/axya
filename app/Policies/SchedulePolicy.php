<?php

namespace App\Policies;

use App\User;
use App\Schedule;
use Illuminate\Auth\Access\HandlesAuthorization;

class SchedulePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create schedules.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->is_doctor;// && $user->doctor->isActive();
    }

    /**
     * Determine whether the user can update the schedule.
     *
     * @param  \App\User  $user
     * @param  \App\Schedule  $schedule
     * @return mixed
     */
    public function update(User $user, Schedule $schedule)
    {
        return $user->is_doctor && $user->id == $schedule->doctor_id;// && $user->doctor->isActive();
    }

    /**
     * Determine whether the user can delete the schedule.
     *
     * @param  \App\User  $user
     * @param  \App\Schedule  $schedule
     * @return mixed
     */
    public function delete(User $user, Schedule $schedule)
    {
        return $user->is_doctor && $user->id == $schedule->doctor_id;// && $user->doctor->isActive();
    }
}
