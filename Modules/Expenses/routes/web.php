<?php

use Illuminate\Support\Facades\Route;
use Modules\Expenses\Livewire\RespondQuotation;

Route::middleware(['web'])->group(function () {
    Route::middleware('signed')
        ->get('purchase/{order}/{action}', RespondQuotation::class)
        ->name('purchases.quotations.respond');
});
