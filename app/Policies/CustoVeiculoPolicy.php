<?php

namespace App\Policies;

use App\Models\CustoVeiculo;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustoVeiculoPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('View CustoVeiculo');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CustoVeiculo $custoVeiculo)
    {
       
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('Create CustoVeiculo');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CustoVeiculo $custoVeiculo): bool
    {
        return $user->hasPermissionTo('Update CustoVeiculo');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CustoVeiculo $custoVeiculo): bool
    {
        return $user->hasPermissionTo('Delete CustoVeiculo');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CustoVeiculo $custoVeiculo)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CustoVeiculo $custoVeiculo)
    {
        //
    }
}
