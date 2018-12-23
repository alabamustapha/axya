<?php

namespace App\Policies;

use App\Appointment;
use App\Review;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewPolicy
{
    use HandlesAuthorization;

    public function create(User $user)/*, Appointment $appointment*/
    {
        return $user->isVerified() && !$user->isSuspended();/* && $appointment->creator*/
    }

    public function edit(User $user, Review $review)/*, Appointment $appointment*/
    {
        return $user->id == $review->user_id;/* && $appointment->creator*/
    }
}
