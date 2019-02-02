<?php

namespace App\Policies;

use App\Transaction;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{
    use HandlesAuthorization;

    // public function view(User $user)//, Transaction $transaction
    // {
    //     return $user->id == request()->user->id//$transaction->user_id
    //             || $user->isAdmin()
    //             // Currently accessed user is a patient to logged in doctor.
    //             || ($user->is_doctor && $user->doctor->inAllPatients())
    //             ;
    // }

    public function create(User $user)
    {
        return $user->isVerified() && !$user->isSuspended();
    }

    public function edit(User $user, Transaction $transaction)
    {
        return $user->id == $transaction->user_id;// || $user->id == $transaction->doctor_id;
    }

    public function delete(User $user, Transaction $transaction)
    {
        return $user->id == $transaction->user_id;
    }
}
