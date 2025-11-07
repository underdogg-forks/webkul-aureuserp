<?php

namespace Modules\Core\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Core\Models\User;
use Modules\Core\Models\CalendarLeave;

class CalendarLeavePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_public::holiday');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CalendarLeave $calendarLeave): bool
    {
        return $user->can('view_public::holiday');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_public::holiday');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CalendarLeave $calendarLeave): bool
    {
        return $user->can('update_public::holiday');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CalendarLeave $calendarLeave): bool
    {
        return $user->can('delete_public::holiday');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_public::holiday');
    }
}
