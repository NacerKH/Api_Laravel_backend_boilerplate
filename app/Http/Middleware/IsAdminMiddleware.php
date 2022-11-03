<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IsAdminMiddleware
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
        // if ($request->user() && $request->user()->role === User::ROLE_ADMIN)  if u doesnt use table role
        // return $next($request);

        if ($request->user() && $request->user()->hasRole('admin') )
        return $next($request);
        
        return response()->json(['message'=>"Only admin allowed to this route "],Response::HTTP_UNAUTHORIZED);

    }
}
