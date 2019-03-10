<?php

namespace App\Policies;

use App\User;
use App\SubscriptionPlan;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubscriptionPlanPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create Subscription Plans.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin();
    }
    
    public function edit(User $user, SubscriptionPlan $subscriptionPlan)
    {
        return $user->isAdmin();
    }

    public function update(User $user, SubscriptionPlan $subscriptionPlan)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the subscription_plan.
     *
     * @param  \App\User  $user
     * @param  \App\SubscriptionPlan  $subscriptionPlan
     * @return mixed
     */
    public function delete(User $user, SubscriptionPlan $subscriptionPlan)
    {
        return $user->isAdmin();
    }
}
