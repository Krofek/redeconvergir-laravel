<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\Initiative;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
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
        return $user->can('manage events') ? true : null; # muy importante "null"
    }

    /**
     * Only users in charge of initiative can update them.
     *
     * @param User $user
     * @param Event $event
     * @return bool
     */
    public function update(User $user, Event $event)
    {
        return !$event->users->where('id', $user->id)->isEmpty();
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
