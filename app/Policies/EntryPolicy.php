<?php

namespace App\Policies;

use App\Entry;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EntryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Entry  $entry
     * @return mixed
     */
    public function view(User $user, Entry $entry)
    {
        return $entry->user->is($user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Entry  $entry
     * @return mixed
     */
    public function update(User $user, Entry $entry)
    {
        return $entry->user->is($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Entry  $entry
     * @return mixed
     */
    public function delete(User $user, Entry $entry)
    {
        return $entry->user->is($user);
    }

}
