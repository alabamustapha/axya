<?php

namespace App\Traits;

use App\Doctor;
use App\Exceptions\ResourceAdministrationException;
use App\User;

/** 
 * Authorization and Exceptions 
 * Checks if request->user has enough authorization to ADMIN (Edit, Delete) a resource. 
 *
 * @param  \App\Model  $model
 * @return App\Exceptions\ResourceAdministrationException
 */
trait CustomAuthorizationsTrait
{
    // To Do: Make this trait dynamic 
    // https://stackoverflow.com/questions/251485/dynamic-class-method-invocation-in-php
    // https://www.designcise.com/web/tutorial/how-to-dynamically-invoke-a-class-method-in-php

    /** ~~~~~~~ User-API */
    public function canEditUser(User $user)
    {
        if (auth()->id() !== $user->id) {
            throw new ResourceAdministrationException;
        }
    }
    public function canRemoveUser(User $user)
    {
        if ((auth()->id() !== $user->id) && (! auth()->user()->isSuperAdmin())) {
            throw new ResourceAdministrationException;
        }
    }

    /** ~~~~~~~ Doctor-API*/
    public function canEditDoctor(Doctor $doctor)
    {
        if (auth()->id() !== $doctor->id) {
            throw new ResourceAdministrationException;
        }
    }
    public function canRemoveDoctor(Doctor $doctor)
    {
        if ((auth()->id() !== $doctor->id) && (! auth()->user()->isSuperAdmin())) {
            throw new ResourceAdministrationException;
        }
    }

}