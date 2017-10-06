<?php

namespace App\Http\Middleware;

use App\Role;
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
        if ($request->user()->role_id == $role || $request->user()->role_id == Role::ADMIN) {
            return $next($request);
        }

        return [
            'authorized' => false,
        ];
    }
}