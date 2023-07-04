<?php

namespace App\Policies;

use App\Models\ContasReceber;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContasReceberPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('View ContasReceber');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ContasReceber $contasReceber)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Create ContasReceber');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ContasReceber $contasReceber): bool
    {
        return $user->hasPermissionTo('Update ContasReceber');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ContasReceber $contasReceber): bool
    {
        return $user->hasPermissionTo('Delete ContasReceber');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ContasReceber $contasReceber)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ContasReceber $contasReceber)
    {
        //
    }
}
