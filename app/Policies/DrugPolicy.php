<?php

namespace App\Policies;

use App\User;
use App\Drug;
use Illuminate\Auth\Access\HandlesAuthorization;

class DrugPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the drug.
     *
     * @param  \App\User  $user
     * @param  \App\Drug  $drug
     * @return mixed
     */
    public function view(User $user, Drug $drug)
    {
        //
    }

    /**
     * Determine whether the user can create drugs.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the drug.
     *
     * @param  \App\User  $user
     * @param  \App\Drug  $drug
     * @return mixed
     */
    public function update(User $user, Drug $drug)
    {
        //
    }

    /**
     * Determine whether the user can delete the drug.
     *
     * @param  \App\User  $user
     * @param  \App\Drug  $drug
     * @return mixed
     */
    public function delete(User $user, Drug $drug)
    {
        //
    }

    /**
     * Determine whether the user can restore the drug.
     *
     * @param  \App\User  $user
     * @param  \App\Drug  $drug
     * @return mixed
     */
    public function restore(User $user, Drug $drug)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the drug.
     *
     * @param  \App\User  $user
     * @param  \App\Drug  $drug
     * @return mixed
     */
    public function forceDelete(User $user, Drug $drug)
    {
        //
    }
}
