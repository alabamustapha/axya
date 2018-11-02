<?php

namespace App\Traits;

use App\Exceptions\EditUserException;

/** 
 * Authorization and Exceptions 
 * Checks if request->user() has enough authorization to ADMIN resource.
 *
 */
trait CustomAuthorizationsTrait
{
    /** 
     * User Admin Authorization and Exceptions 
     * Checks if request->user() has authorization to edit resource.
     * @target API
     *
     * @param  \App\User  $user
     * @return App\Exceptions\EditUserException
     */
    public function canEditUser(User $user)
    {
        if (auth()->id() !== $user->id) {
            throw new EditUserException;
        }
    }

    /** 
     * User Admin Authorization and Exceptions 
     * Checks if request->user() has authorization to DESTROY a User resource.
     * @target API
     *
     * @param  \App\User  $user
     * @return App\Exceptions\EditUserException
     */
    public function canRemoveUser(User $user)
    {
        if ((auth()->id() !== $user->id) || auth()->user()->isSuperAdmin()) {
            throw new EditUserException;
        }
    }

}