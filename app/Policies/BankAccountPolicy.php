<?php

namespace App\Policies;

use App\BankAccount;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BankAccountPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->isVerified();
    }

    public function edit(User $user, BankAccount $bankAccount)
    {
        return $user->id == $bankAccount->user_id;
    }

    public function delete(User $user, BankAccount $bankAccount)
    {
        return $user->id == $bankAccount->user_id;
    }
}
