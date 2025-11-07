<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Livewire\AcceptInvitation;

Route::middleware(['web'])->group(function () {
    Route::middleware('signed')
        ->get('invitation/{invitation}/accept', AcceptInvitation::class)
        ->name('security.invitation.accept');
});
