<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MfaMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        return $request->user()->hasEnabledTwoFactorAuthenticationConfirmed() ?
            $next($request) : response()->json('Provide to confirm two factory Authentification code code ');
    }
}
