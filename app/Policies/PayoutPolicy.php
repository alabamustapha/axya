<?php

namespace App\Policies;

use App\Payout;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PayoutPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->isVerified() 
                && (($user->is_doctor /*&& $user->doctor->hasWithrawableBalance()*/) || $user->is_super_admin);
    }
}
