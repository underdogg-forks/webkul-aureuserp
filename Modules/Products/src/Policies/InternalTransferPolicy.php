<?php

namespace Modules\Products\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Products\Models\InternalTransfer;
use Modules\Core\Models\User;
use Modules\Core\Traits\HasScopedPermissions;

class InternalTransferPolicy
{
    use HandlesAuthorization;
    use HasScopedPermissions;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_internal');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, InternalTransfer $internalTransfer): bool
    {
        return $user->can('view_internal');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_internal');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, InternalTransfer $internalTransfer): bool
    {
        if ( ! $user->can('update_internal')) {
            return false;
        }

        return $this->hasAccess($user, $internalTransfer);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, InternalTransfer $internalTransfer): bool
    {
        if ( ! $user->can('delete_internal')) {
            return false;
        }

        return $this->hasAccess($user, $internalTransfer);
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_internal');
    }
}
