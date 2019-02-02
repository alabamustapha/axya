<?php

namespace App\Policies;

use App\Subscription;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubscriptionPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return (($user->id == auth()->id()) || $user->is_admin);
    }

    public function view(User $user, Subscription $subscription)
    {
        return ($user->is_doctor && $user->id == $subscription->doctor_id) || $user->is_admin;
    }

    public function create(User $user)
    {
        return     $user->is_doctor 
                && $user->isVerified() 
                && $user->doctor->isActive() 
                && !$user->isSuspended();
    }

    public function edit(User $user, Subscription $ubscription)
    {
        return $user->id == $ubscription->doctor_id;
    }

    public function delete(User $user, Subscription $ubscription)
    {
        return $user->id == $ubscription->doctor_id;
    }
}
