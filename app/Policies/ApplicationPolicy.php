<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->isVerified();
    }

    public function delete(User $user, Application $application)
    {
        return $user->isAdmin();
    }
}
