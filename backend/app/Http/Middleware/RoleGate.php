<?php

namespace App\Http\Middleware;

use Closure;

class RoleGate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        // error_log($request->user()->role);
        if ($request->user() && $request->user()->roles && $request->user()->roles->slug === $role) {
            $request->role = 'admin';
            return $next($request);
        }
        else {
            return response()->json(["success" => false,
                'message' => 'Denied'
            ],200);
        }
    }
}
