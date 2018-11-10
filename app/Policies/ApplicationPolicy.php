<?php

namespace App\Policies;

use App\Application;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->isVerified();
    }

    public function edit(User $user, Application $application)
    {
        return $application->user_id == $user->id;
    }

    public function admin(User $user, Application $application)
    {
        return $application->user_id == $user->id || $user->isAdmin();
    }

    public function delete(User $user, Application $application)
    {
        return $application->user_id == $user->id || $user->isAdmin();
    }
}
