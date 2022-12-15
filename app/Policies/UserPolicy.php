<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view the users list.
     *
     * @param  \App\Models\User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view user profile page.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $model
     * @return bool
     */
    public function view(User $user, User $model): bool
    {
        return $user->isAdmin() || $user->id === $model->user_id;
    }

    /**
     * Determine whether the user can create users.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the given user can be updated by the user.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $model
     * @return bool
     */
    public function update(User $user, User $model): bool
    {
        return $user->isAdmin() || $user->id === $model->user_id;
    }

    /**
     * Determine if the given user can be deleted by the user.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $model
     * @return bool
     */
    public function delete(User $user, User $model): bool
    {
        return $user->isAdmin();
    }
}
