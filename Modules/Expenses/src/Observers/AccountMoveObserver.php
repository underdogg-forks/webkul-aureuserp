<?php

namespace Modules\Expenses\Observers;

use Modules\Expenses\Models\AccountMove;

class AccountMoveObserver
{
    /**
     * Handle the User "updated" event.
     */
    public function updated($move): void
    {
        if ($move->isDirty('state')) {
            $accountMove = AccountMove::find($move->id);

            $oldValue = $move->getOriginal('state');
            $newValue = $move->state;

            dd($accountMove, $oldValue, $newValue);
        }
    }
}
