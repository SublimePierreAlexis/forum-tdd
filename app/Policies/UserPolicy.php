<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the given profile.
     *
     * @param  \App\User $user
     * @param User       $signedInUser
     *
     * @return mixed
     */
    public function update(User $user, User $signedInUser)
    {
        return $user->id === $signedInUser->id;
    }
}
