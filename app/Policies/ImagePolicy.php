<?php

namespace App\Policies;

use App\User;
use App\Image;
use Illuminate\Auth\Access\HandlesAuthorization;

class ImagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the image.
     *
     * @param  \App\User  $user
     * @param  \App\Image  $image
     * @return mixed
     */
    public function delete(User $user, Image $image)
    {
        return $image->user_id == $user->id || $user->isAdmin();
    }

    public function upload(User $user, Image $image)
    {
        return $user->isActive();// || $user->isVerified();
    }
}
