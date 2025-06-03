<?php

namespace Silaswint\LaravelImpersonateGuest\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ImpersonateGuest
{
    public const SESSION_KEY = 'impersonate_guest';
    public const SESSION_USER_ID_KEY = 'original_user_id';

    public function handle(Request $request, Closure $next): Response
    {
        if (session(self::SESSION_KEY, false)) {
            if (Auth::check() && !session()->has(self::SESSION_USER_ID_KEY)) {
                session([self::SESSION_USER_ID_KEY => Auth::id()]);
            }

            Auth::logout(); // Simuliert den Gast-Modus
        }

        return $next($request);
    }
}
