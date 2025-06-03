<?php

if (! function_exists('isImpersonatingGuest')) {
    function isImpersonatingGuest(): bool
    {
        return session(\Silaswint\LaravelImpersonateGuest\App\Http\Middleware\ImpersonateGuest::SESSION_KEY, false);
    }
}
