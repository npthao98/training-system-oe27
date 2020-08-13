<?php

namespace App\Http\Middleware;

use Closure;

class CheckSupervisor
{
    public function handle($request, Closure $next)
    {
        if (auth()->user()->role_id == config('number.role.supervisor')) {
            return $next($request);
        } else {
            abort(500);
        }
    }
}
