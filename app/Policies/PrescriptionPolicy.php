<?php

namespace App\Policies;

use Carbon;
use App\User;
use App\Prescription;
use Illuminate\Auth\Access\HandlesAuthorization;

class PrescriptionPolicy
{
    use HandlesAuthorization;

    public function show(User $user, Prescription $prescription)
    {
        return $user->id == $prescription->appointment->user_id 
            || $user->id == $prescription->appointment->doctor_id
            ;
    }

    public function create(User $user)
    {
        return $user->isDoctor();
    }

    public function edit(User $user, Prescription $prescription)
    {
        return $user->isDoctor() 
            && $user->id == $prescription->appointment->doctor_id 
            // && $prescription->created_at->addMinutes(90) < Carbon::now()
            ;
    }

    public function delete(User $user, Prescription $prescription)
    {
        return $user->isDoctor() 
            && $user->id == $prescription->appointment->doctor_id 
            // && $prescription->created_at->addMinutes(90) < Carbon::now()
            ;
    }
}
