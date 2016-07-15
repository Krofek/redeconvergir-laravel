<?php

namespace App\Policies;

use App\Models\Initiative;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InitiativePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Initiative $initiative)
    {
        return $initiative->user_id === $user->id;
    }
}
