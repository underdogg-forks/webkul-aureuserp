<?php

use Illuminate\Support\Facades\Route;
use Modules\Quotes\Http\Controllers\QuotesController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('quotes', QuotesController::class)->names('quotes');
});
