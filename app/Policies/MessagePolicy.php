<?php

namespace App\Policies;

use App\User;
use App\Models\Message;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User $user
     * @param Message $model
     * @return mixed
     */
    public function view(User $user)
    {
        if($user->id === '2dab4e80-2b81-11e8-ab04-51151db1447e') {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     * 
     *
     * @param  \App\User $user
     * @param Message $model
     * @return mixed
     */
    public function update(User $user, Message $model)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User $user
     * @param Message $model
     * @return mixed
     */
    public function delete(User $user, Message $model)
    {
        return false;
    }
}