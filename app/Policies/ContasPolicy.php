<?php

namespace App\Policies;

use App\Conta;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContasPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Conta  $conta
     * @return mixed
     */
    public function view(User $user, Conta $conta)
    {
        return $user->id === $conta->user->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Conta  $conta
     * @return mixed
     */
    public function update(User $user, Conta $conta)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Conta  $conta
     * @return mixed
     */
    public function delete(User $user, Conta $conta)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Conta  $conta
     * @return mixed
     */
    public function restore(User $user, Conta $conta)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Conta  $conta
     * @return mixed
     */
    public function forceDelete(User $user, Conta $conta)
    {
        //
    }
}
