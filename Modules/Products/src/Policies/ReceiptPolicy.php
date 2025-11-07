<?php

namespace Modules\Products\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Products\Models\Receipt;
use Modules\Core\Models\User;
use Modules\Core\Traits\HasScopedPermissions;

class ReceiptPolicy
{
    use HandlesAuthorization;
    use HasScopedPermissions;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_receipt');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Receipt $receipt): bool
    {
        return $user->can('view_receipt');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_receipt');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Receipt $receipt): bool
    {
        if ( ! $user->can('update_receipt')) {
            return false;
        }

        return $this->hasAccess($user, $receipt);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Receipt $receipt): bool
    {
        if ( ! $user->can('delete_receipt')) {
            return false;
        }

        return $this->hasAccess($user, $receipt);
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_receipt');
    }
}
