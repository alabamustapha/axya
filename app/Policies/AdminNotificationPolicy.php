<?php

namespace App\Policies;

use Carbon;
use App\User;
use App\AdminNotification;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminNotificationPolicy
{
    use HandlesAuthorization;

    public function show(User $user, AdminNotification $adminNotification)
    {
        return $user->isAdmin() && $user->isAuthenticatedAdmin();
    }

    public function create(User $user)
    {
        return $user->isAdmin() && $user->isAuthenticatedAdmin();
    }
}
