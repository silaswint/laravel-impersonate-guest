<?php

namespace Silaswint\LaravelImpersonateGuest\App\Listeners\Login;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Session;
use Silaswint\LaravelImpersonateGuest\App\Http\Middleware\ImpersonateGuest;

class ClearImpersonationGuestSession
{
    public function handle(Login $event): void
    {
        Session::forget(ImpersonateGuest::SESSION_KEY);
        Session::forget(ImpersonateGuest::SESSION_USER_ID_KEY);
    }
}
