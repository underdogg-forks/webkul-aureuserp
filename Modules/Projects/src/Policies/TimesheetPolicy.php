<?php

namespace Modules\Projects\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Projects\Models\Timesheet;
use Modules\Core\Models\User;
use Modules\Core\Traits\HasScopedPermissions;

class TimesheetPolicy
{
    use HandlesAuthorization;
    use HasScopedPermissions;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Timesheet $timesheet): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Timesheet $timesheet): bool
    {
        return true;
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return true;
    }
}
