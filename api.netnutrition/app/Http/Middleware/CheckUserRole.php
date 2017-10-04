<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Closure $next
     * @param string $role
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if ($request->user()->role_id == $role) {
            return $next($request);
        }

        return redirect()->route('welcome');
    }
}