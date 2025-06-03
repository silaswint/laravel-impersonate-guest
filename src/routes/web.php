<?php

use Illuminate\Support\Facades\Route;
use Silaswint\LaravelImpersonateGuest\App\Http\Controllers\ImpersonateGuestController;

Route::post('/impersonate-guest-start', [ImpersonateGuestController::class, 'start'])
    ->middleware('web')
    ->name('impersonate-guest-start');

Route::post('/impersonate-guest-end', [ImpersonateGuestController::class, 'end'])
    ->middleware('web')
    ->name('impersonate-guest-end');
