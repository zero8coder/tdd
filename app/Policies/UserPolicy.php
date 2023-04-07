<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function update(User $signedInUser, User $user): bool
    {
        return $signedInUser->id === $user->id;
    }


}
