<?php

namespace App\Policies;

use App\Models\Initiative;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InitiativePolicy
{
    use HandlesAuthorization;

    /**
     * Those who manage initiatives can create, update and delete them.
     *
     * @param User $user
     * @return bool|null
     */
    public function before(User $user)
    {
        return $user->can('manage initiatives') ? true : null; # muy importante "null"
    }

    /**
     * Only users in charge of initiative can update them.
     *
     * @param User $user
     * @param Initiative $initiative
     * @return bool
     */
    public function update(User $user, Initiative $initiative)
    {
        return !$initiative->users->where('id', $user->id)->isEmpty();
    }

    /**
     * Logged in users can create initiatives.
     *
     * @return bool
     */
    public function create()
    {
        return \Auth::check();
    }
}
