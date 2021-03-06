<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentsPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->isVerified();
    }

    public function delete(User $user, Document $document)
    {
        return $user->isAdmin();
    }
}
