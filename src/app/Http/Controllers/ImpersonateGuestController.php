<?php

namespace Silaswint\LaravelImpersonateGuest\App\Http\Controllers;

use Silaswint\LaravelImpersonateGuest\App\Http\Middleware\ImpersonateGuest;
use Silaswint\LaravelImpersonateGuest\App\Interfaces\HasImpersonateGuest;

class ImpersonateGuestController extends Controller
{
    public function start() {
        /** @var HasImpersonateGuest $user */
        $user = auth()->user();

        if (! $user?->canImpersonateGuest()) {
            return response()->json(['status' => 'error'], 403);
        }

        session([ImpersonateGuest::SESSION_KEY => true]);

        return response()->json(['status' => 'ok']);
    }

    public function end() {
        session()->forget(ImpersonateGuest::SESSION_KEY);

        if (auth()->guest() && session()->has(ImpersonateGuest::SESSION_USER_ID_KEY)) {
            auth()->loginUsingId(session(ImpersonateGuest::SESSION_USER_ID_KEY));
            session()->forget(ImpersonateGuest::SESSION_USER_ID_KEY);
        }

        return response()->json(['status' => 'ok']);
    }
}
